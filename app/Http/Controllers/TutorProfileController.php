<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use App\Models\TutorProfile;
use Illuminate\Http\Request;

class TutorProfileController extends Controller
{
    public function createTutorProfile(Request $request){
        // dd($request->input());
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'required|string|max:1000',
            'education' => 'required|string|max:255',
            'teaching_experience' => 'required|string|max:100',
            'hourly_rate' => 'required|integer|min:0',
        ]);

        // Create a new tutor profile
        $tutorProfile = TutorProfile::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'bio' => $request->bio,
            'education' => $request->education,
            'teaching_experience' => $request->teaching_experience,
            'hourly_rate' => $request->hourly_rate,
        ]);

        //Create availability

        $validatedData = $request->validate([
        // Validate the main array exists
            'availability' => 'required|array|size:7',

            // Validate each item inside the array
            'availability.*.day_of_week' => 'required|string',
            'availability.*.enabled' => 'nullable|string', // It's either 'on' or null

            // Start time is required ONLY IF 'enabled' is present
            'availability.*.start_time' => 'nullable|required_with:availability.*.enabled|date_format:H:i',

            // End time is also required and must be after the start time
            'availability.*.end_time' => 'nullable|required_with:availability.*.enabled|date_format:H:i|after:availability.*.start_time',
        ]);

        // Loop through the *validated* data
        foreach ($validatedData['availability'] as $dayData) {

            if (isset($dayData['enabled'])) {
                Availability::create([
                    'tutor_profile_id' => auth()->user()->tutorProfile->id,
                    'day_of_week' => $dayData['day_of_week'],
                    'start_time' => $dayData['start_time'],
                    'end_time' => $dayData['end_time'],
                ]);
            }
        }

        // Return a success response
        return redirect()->back()->with("Sucessfully Registered Tutor Profile");

    }

    public function updateTutorProfile(Request $request)
    {
        // 1. Find the user's existing tutor profile
        $tutorProfile = auth()->user()->tutorProfile;

        if (!$tutorProfile) {
            return redirect()->back()->withErrors(['general' => 'You do not have a tutor profile to update.']);
        }

        // 2. Validate all the incoming data
        $validatedData = $request->validate([
            // Tutor Profile fields
            'name' => 'required|string|max:255',
            'bio' => 'required|string|max:1000',
            'education' => 'required|string|max:255',
            'teaching_experience' => 'required|string|max:100',
            'hourly_rate' => 'required|integer|min:0',

            // Subject fields
            'subjects' => 'nullable|array',
            'subjects.*' => 'exists:subjects,id', // Ensures every subject ID is valid

            // Availability fields
            'availability' => 'required|array|size:7',
            'availability.*.day_of_week' => 'required|string',
            'availability.*.enabled' => 'nullable|string',
            'availability.*.start_time' => 'nullable|required_with:availability.*.enabled|date_format:H:i',
            'availability.*.end_time' => 'nullable|required_with:availability.*.enabled|date_format:H:i|after:availability.*.start_time',
        ]);

        // 3. Update the main TutorProfile model
        $tutorProfile->update([
            'name' => $validatedData['name'],
            'bio' => $validatedData['bio'],
            'education' => $validatedData['education'],
            'teaching_experience' => $validatedData['teaching_experience'],
            'hourly_rate' => $validatedData['hourly_rate'],
        ]);

        // 4. Update Subjects: sync() deletes old/adds new
        if (!empty($validatedData['subjects'])) {
            $tutorProfile->subjects()->sync($validatedData['subjects']);
        } else {
            $tutorProfile->subjects()->sync([]); // Detach all subjects if empty
        }

        // 5. Update Availability: Delete all old ones first
        $tutorProfile->availabilities()->delete();

        // And create the new ones
        foreach ($validatedData['availability'] as $dayData) {
            if (isset($dayData['enabled'])) {
                // Create new availability record
                $tutorProfile->availabilities()->create([
                    'day_of_week' => $dayData['day_of_week'],
                    'start_time' => $dayData['start_time'],
                    'end_time' => $dayData['end_time'],
                ]);
            }
        }

        // 6. Return a success response
        return redirect()->back()->with('status', 'Tutor profile updated successfully!');
    }


    public function associateSubjects($subjects,$id){
        $tutor = TutorProfile::find($id);
        $tutor->subjects()->attach($subjects);
        return response()->json(['message' => 'Subjects associated successfully'], 200);
    }

    public function disassociateSubject($id){
        $tutor = TutorProfile::find($id);
        $tutor->subjects()->detach();
        return response()->json(['message' => 'Subjects deleted successfully'], 200);
    }

    public function addAvailability(Request $request, $id){
        $validatedData = $request->validate([
            'day_of_week' => 'required|string|max:10',
            'start_time' => 'required|string|max:5',
            'end_time' => 'required|string|max:5',
        ]);

        $tutor = TutorProfile::find($id);
        $tutor->availabilities()->create($validatedData);

        return response()->json(['message' => 'Availability added successfully'], 201);
    }

    public function removeAvailability(Request $request, $id){
        $validatedData = $request->validate([
            'day_of_week' => 'required|string|max:10',
            'start_time' => 'required|string|max:5',
            'end_time' => 'required|string|max:5',
        ]);

        $tutor = TutorProfile::find($id);
        $tutor->availabilities()->where($validatedData)->delete();

        return response()->json(['message' => 'Availability removed successfully'], 200);
    }

    public function viewTutor(TutorProfile $tutorProfile){
        $tutorProfile->load('subjects', 'ratings');

        // Get the total count of ratings
        $ratings = $tutorProfile->ratings()->with('student')->paginate(5);
        $ratingsTotal = $ratings->total();
        $avgRating = $tutorProfile->ratings()->avg('rating');

        $availabilites = $tutorProfile->availabilities;

        // You can also calculate the average rating if you store it
        // $averageRating = $tutorProfile->ratings->avg('rating');

        // Pass the tutor, the ratings count, and all reviews to the view
        return view('tutor-profile', [
            'tutorProfile' => $tutorProfile,
            'ratingsCount' => $ratingsTotal,
            'ratings' => $ratings,
            'availabilities' => $availabilites,
            'avgRating' => $avgRating
            // 'reviews' => $tutorProfile->ratings // Pass all ratings/reviews
        ]);
    }
}
