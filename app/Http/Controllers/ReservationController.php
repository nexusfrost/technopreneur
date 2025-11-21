<?php

namespace App\Http\Controllers;

use App\Mail\ReservationAccepted;
use App\Mail\ReservationRejected;
use App\Models\Rating;
use App\Models\Reservation;
use App\Models\TutorProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
    public function createReservation(Request $request)
    {
        // 1. Validate
        $request->validate([
            'tutor_profile_id' => 'required|exists:tutor_profiles,id',
            'reservation_date' => 'required|date|after_or_equal:today',
            'start_time'       => 'required|date_format:H:i', // Expects format like "14:00"
            'duration'         => 'required|integer|min:1|max:8', // Limit duration to reasonable hours
        ]);

        // 2. Calculate Time Interval
        // Parse the start time provided by the user
        $startTime = Carbon::parse($request->start_time);

        // Create a copy of start time and add the duration (in hours) to get end_time
        $endTime = $startTime->copy()->addHours((int) $request->duration);

        // 3. Calculate Price
        // We need the tutor's hourly rate to calculate the total
        $tutor = TutorProfile::findOrFail($request->tutor_profile_id);
        $totalPrice = $tutor->hourly_rate * $request->duration;

        // 4. Create the Reservation
        $reservation = Reservation::create([
            'tutor_profile_id' => $request->tutor_profile_id,
            'student_id'       => auth()->id(), // Always use auth ID for security
            'reservation_date' => $request->reservation_date,
            'start_time'       => $startTime->format('H:i:s'),
            'end_time'         => $endTime->format('H:i:s'), // Derived from duration
            'price'            => $totalPrice,
            'status'           => 'pending' // Default status
        ]);

        // 5. Return Success
        return back()->with('status', 'Reservation created successfully!');
        // Or if using API:
        // return response()->json(['message' => 'Reservation created', 'data' => $reservation], 201);
    }

    public function updateLink(Request $request, Reservation $reservation)
{
        // 1. Validate
        $request->validate([
            'meeting_link' => 'required|url'
        ]);

        // 2. Update (No need to find() manually, Laravel did it already!)
        $reservation->update([
            'meeting_link' => $request->meeting_link
        ]);

        return back()->with('status', 'Meeting link updated successfully!');
    }

    public function accept(Reservation $reservation){
        // Optional: Validate that a reason was provided


            // 1. Update the database
            $reservation->update([
                'status' => 'accepted'
            ]);

            // 2. Send the email with the reason
            if ($reservation->student->email) {
                // Pass the reason ($request->reason) to the Mailable
                Mail::to($reservation->student->email)->send(new ReservationAccepted($reservation));
            }

            // 3. Return response
            return back()->with('status', "Successfully accepted session and sent email!");
    }

    public function reject(Request $request, Reservation $reservation)
    {
            // Optional: Validate that a reason was provided
            $request->validate([
                'reason' => 'required|string|max:500',
            ]);

            // 1. Update the database
            $reservation->update([
                'status' => 'rejected'
            ]);

            // 2. Send the email with the reason
            if ($reservation->student->email) {
                // Pass the reason ($request->reason) to the Mailable
                Mail::to($reservation->student->email)->send(new ReservationRejected($reservation, $request->reason));
            }

            // 3. Return response
            return back()->with('status', "Successfully rejected session and sent email!");
        }


    public function cancel(Reservation $reservation){
        $reservation->update([
            'status' => 'cancelled'
        ]);

        return back()->with('status',"Sucessfully cancelled session!");
    }

    public function downPayment(Reservation $reservation){
        $reservation->update([
            'status' => 'ongoing'
        ]);

        return back()->with('status','Down Payment successfully paid!');
    }

    public function end(Reservation $reservation){
        $reservation->update([
            'status' => 'done'
        ]);


        $reservation->tutor->increment('balance', $reservation->price);

        return back()->with('status','Final Payment successfully paid!');

    }

    public function storeRating(Request $req) {

        // 1. Validate inputs
        $validated = $req->validate([
            'reservation_id' => 'required|integer|exists:reservations,id',
            'tutor_profile_id' => 'required|integer|exists:tutor_profiles,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string'
        ]);

        // 2. SECURITY CHECK: Ensure this reservation actually belongs to the logged-in student
        // We look for a reservation with that ID AND that student_id
        $reservation = Reservation::where('id', $req->reservation_id)
                                ->where('student_id', auth()->id())
                                ->firstOrFail(); // Will show 404 if user tries to hack

        // 3. Create the Rating
        $rating = Rating::create([
            'tutor_profile_id' => $req->tutor_profile_id,
            'reservation_id'   => $req->reservation_id,
            'rating'           => $req->rating,
            'student_id'       => auth()->id(),
            'review'           => $req->review
        ]);

        // 4. Update the Reservation to link the rating
        // This stops it from showing up in "notRated()"
        $reservation->update([
            'rating_id' => $rating->id
        ]);

        $reservation->tutor->update([
            'rating' => $reservation->tutor->ratings()->avg('rating')
        ]);

        // 5. Return with the correct key
        return back()->with('status', 'Thanks for the review!');
    }

    public function cashout(){
        auth()->user()->tutorProfile()->update(['balance' => 0]);
        return back()->with('status', 'Successfully cashed out!');

    }
}
