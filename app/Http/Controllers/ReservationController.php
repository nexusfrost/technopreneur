<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservationController extends Controller
{
    function createReservation(Request $request) {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'tutor_id' => 'required|integer',
            'student_id' => 'required|integer',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required|string',
            'duration' => 'required|integer|min:1',
        ]);

        // Create a new reservation (this is a placeholder, replace with actual model logic)
        // Reservation::create($validatedData);

        // Return a success response
        return response()->json(['message' => 'Reservation created successfully'], 201);
    }
}
