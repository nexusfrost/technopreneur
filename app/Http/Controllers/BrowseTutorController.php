<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\TutorProfile;
use Illuminate\Http\Request;

class BrowseTutorController extends Controller
{
    public function index(){
        $tutors = TutorProfile::paginate(12 );
        $subjects = Subject::all();
        return view('browse-tutors', compact('tutors','subjects'));
    }

    public function search(Request $request)
    {
        // 1. Get all subjects for the dropdown in the view
        $subjects = Subject::all();

        // 2. Make validation fields 'nullable' so it doesn't fail if they are empty
        $validatedData = $request->validate([
            'search' => 'nullable|string',
            'min_rate' => 'nullable|integer',
            'max_rate' => 'nullable|integer',
            'subject' => 'nullable|integer' // Assumes 'subject' is the subject_id
        ]);

        // 3. Start with a base query
        $query = TutorProfile::query();

        // 4. Conditionally add filters using the $validatedData array (it's safer)
        if (!empty($validatedData['search'])) {
            $query->where('name', 'LIKE', '%' . $validatedData['search'] . '%');
        }

        if (!empty($validatedData['min_rate'])) {
            $query->where('hourly_rate', '>=', $validatedData['min_rate']);
        }

        if (!empty($validatedData['max_rate'])) {
            $query->where('hourly_rate', '<=', $validatedData['max_rate']);
        }

        // 5. This is the many-to-many filter
        if (!empty($validatedData['subject']) || $validatedData['subject'] != '0') {
            $query->whereHas('subjects', function ($subQuery) use ($validatedData) {
                $subQuery->where('subjects.id', $validatedData['subject']);
            });
        }

        // 6. Use paginate() so your links in the view still work!
        $tutors = $query->paginate(12);

        // 7. Return the view with the filtered tutors and all subjects
        return view('browse-tutors', compact('tutors', 'subjects'));
    }
}
