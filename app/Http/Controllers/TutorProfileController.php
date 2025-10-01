<?php

namespace App\Http\Controllers;

use App\Models\TutorProfile;
use Illuminate\Http\Request;

class TutorProfileController extends Controller
{
    public function createTutor(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'required|string|max:1000',
            'education' => 'required|string|max:255',
            'teaching_experience' => 'required|string|max:1000',
            'hourly_rate' => 'required|integer|min:0',
        ]);

        // Create a new tutor profile
        $tutorProfile = TutorProfile::create($validatedData);

        // Return a success response
        return response()->json(['message' => 'Tutor profile created successfully', 'tutorProfile' => $tutorProfile], 201);

    }
}
