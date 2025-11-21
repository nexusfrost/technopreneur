<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $authId = Auth::id();

        // 1. Find all users I have chatted with (Sent OR Received)
        // We get distinct receiver_ids from messages I sent
        $sentTo = Message::where('sender_id', $authId)
                        ->distinct()
                        ->pluck('receiver_id');

        // We get distinct sender_ids from messages I received
        $receivedFrom = Message::where('receiver_id', $authId)
                        ->distinct()
                        ->pluck('sender_id');

        // Merge the lists and remove duplicates
        $chatUserIds = $sentTo->merge($receivedFrom)->unique();

        // 2. Handle "Initiate Chat" (Deep Link from Tutor Profile)
        // If URL is /chat?user_id=5, we MUST include user 5 in the list
        // even if we haven't chatted yet.
        if ($request->has('user_id')) {
            $targetUserId = (int) $request->query('user_id');
            if ($targetUserId !== $authId) {
                $chatUserIds->push($targetUserId);
            }
        }

        // 3. Fetch the User objects for the sidebar
        $users = User::whereIn('id', $chatUserIds)
                     ->select('id', 'name', 'email') // Optimization: only select needed columns
                     ->get();

        return view('chat', ['users' => $users]);
    }

    public function show(User $user)
    {
        // Fetch conversation between authenticated user and selected user
        // (Message sent BY me TO you) OR (Message sent BY you TO me)
        $messages = Message::where(function($query) use ($user) {
                $query->where('sender_id', Auth::id())
                      ->where('receiver_id', $user->id);
            })
            ->orWhere(function($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', Auth::id());
            })
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    public function send(Request $request, User $user)
    {
        $request->validate(['text' => 'required']);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'text' => $request->text,
        ]);

        // Fire event so the receiver sees it instantly
        MessageSent::dispatch($message);

        return response()->json($message);
    }
}
