<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\TutorProfile; // Assuming you have this model
use App\Models\User; // Assuming you have this model

class DashboardController extends Controller
{
    /**
     * Update the user's basic profile information.
     * Corresponds to the "Edit Profile" modal.
     */

    public function index(){



        if(auth()->user()->tutorProfile){
            $tutor = auth()->user()->tutorProfile;
            $pendingRatingSession = auth()->user()->notRated()->first();
            $reservations = auth()->user()->reservations()->get();
            $categories = Category::with('subjects')->get();
            $totalEarnings = $tutor->reservations()->where('status','=','done')->sum('price');
            $tutorBookings = $tutor->reservations()->where('status','=','done')->count();
            $tutorRatings = $tutor->ratings();
            $tutorReservations = $tutor->reservations()->get();
            $subjects = $tutor->subjects->pluck('id')->toArray();
            return view('dashboard', compact('categories','subjects','tutorReservations','pendingRatingSession','reservations','tutorBookings','totalEarnings','tutorRatings'));

        }else{
            $pendingRatingSession = auth()->user()->notRated()->first();
            $reservations = auth()->user()->reservations()->whereNot('status','done')->whereNot('status','cancelled');
            $categories = Category::with('subjects')->get();
            return view('dashboard', compact('categories','reservations','pendingRatingSession'));
        }

    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $validatedData['name'];

        // Only update password if a new one was provided
        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        return redirect()->back()->with('status', 'Profile updated successfully!');
    }

    /**
     * Create a new tutor profile for the authenticated user.
     * Corresponds to the "Become a Tutor" modal/form.
     */
    public function storeTutorProfile(Request $request)
    {
        // Prevent creating a profile if one already exists for the user
        if ($request->user()->tutorProfile) {
            return redirect()->back()->withErrors(['general' => 'You already have a tutor profile.']);
        }

        $validatedData = $request->validate([
            'bio' => 'required|string|max:2000',
            'education' => 'required|string|max:255',
            'experience' => 'required|string|max:255',
            'hourly_rate' => 'required|numeric|min:1',
            'subjects' => 'nullable|array',
            'subjects.*' => 'string|max:100', // Validate each item in the subjects array
            'availability' => 'nullable|array',
            'availability.*.enabled' => 'nullable', // Checkbox for enabling the day
            'availability.*.day_of_week' => 'required|string',
            'availability.*.start_time' => 'nullable|date_format:H:i',
            'availability.*.end_time' => 'nullable|date_format:H:i|after:availability.*.start_time',
        ]);

        // Create the main tutor profile
        $tutorProfile = $request->user()->tutorProfile()->create([
            'bio' => $validatedData['bio'],
            'education' => $validatedData['education'],
            'experience' => $validatedData['experience'],
            'hourly_rate' => $validatedData['hourly_rate'],
            'subjects' => $validatedData['subjects'] ?? [], // Store subjects as a JSON array
        ]);

        // Process and create the availability records
        if (isset($validatedData['availability'])) {
            foreach ($validatedData['availability'] as $day) {
                // Only create the record if the day was checked as 'enabled'
                if (isset($day['enabled'])) {
                    $tutorProfile->availabilities()->create([
                        'day_of_week' => $day['day_of_week'],
                        'start_time' => $day['start_time'],
                        'end_time' => $day['end_time'],
                    ]);
                }
            }
        }

        return redirect()->back()->with('status', 'Tutor profile created successfully!');
    }

    /**
     * Update an existing tutor profile.
     * Corresponds to the "Edit Tutor Profile" modal.
     */
    public function updateTutorProfile(Request $request)
    {
        $tutorProfile = $request->user()->tutorProfile;

        // Ensure the user has a tutor profile to update
        if (!$tutorProfile) {
            return redirect()->back()->withErrors(['general' => 'No tutor profile found to update.']);
        }

        $validatedData = $request->validate([
            'bio' => 'required|string|max:2000',
            'education' => 'required|string|max:255',
            'experience' => 'required|string|max:255',
            'hourly_rate' => 'required|numeric|min:1',
            'subjects' => 'nullable|array',
            'subjects.*' => 'string|max:100',
            'availability' => 'nullable|array',
            'availability.*.enabled' => 'nullable',
            'availability.*.day_of_week' => 'required|string',
            'availability.*.start_time' => 'nullable|date_format:H:i',
            'availability.*.end_time' => 'nullable|date_format:H:i|after:availability.*.start_time',
        ]);

        // Update the main profile attributes
        $tutorProfile->update([
            'bio' => $validatedData['bio'],
            'education' => $validatedData['education'],
            'experience' => $validatedData['experience'],
            'hourly_rate' => $validatedData['hourly_rate'],
            'subjects' => $validatedData['subjects'] ?? [],
        ]);

        // Easiest way to update availability is to delete the old ones and create the new ones
        $tutorProfile->availabilities()->delete();

        if (isset($validatedData['availability'])) {
            foreach ($validatedData['availability'] as $day) {
                if (isset($day['enabled'])) {
                    $tutorProfile->availabilities()->create([
                        'day_of_week' => $day['day_of_week'],
                        'start_time' => $day['start_time'],
                        'end_time' => $day['end_time'],
                    ]);
                }
            }
        }

        return redirect()->back()->with('status', 'Tutor profile updated successfully!');
    }
}
