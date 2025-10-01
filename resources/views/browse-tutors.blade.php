<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Tutors</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .text-primary { color: #3b82f6; }
        .border-primary { border-color: #3b82f6; }
    </style>
</head>
<body class="bg-white text-gray-800">

@php
// Dummy data to simulate database queries
$subjects = [
    (object)['_id' => 1, 'name' => 'Calculus', 'category' => 'Mathematics'],
    (object)['_id' => 2, 'name' => 'Statistics', 'category' => 'Mathematics'],
    (object)['_id' => 3, 'name' => 'Physics', 'category' => 'Science'],
    (object)['_id' => 4, 'name' => 'Chemistry', 'category' => 'Science'],
    (object)['_id' => 5, 'name' => 'Web Development', 'category' => 'Technology'],
    (object)['_id' => 6, 'name' => 'Data Science', 'category' => 'Technology'],
];

$filteredTutors = [
    (object)[
        '_id' => 101,
        'user' => (object)['name' => 'John Doe', 'image' => 'https://i.pravatar.cc/150?img=1'],
        'rating' => 4.9,
        'totalReviews' => 120,
        'bio' => 'Experienced mathematics professor with a passion for helping students succeed in calculus and statistics.',
        'hourlyRate' => 50,
        'subjects' => ['Calculus', 'Statistics', 'Algebra']
    ],
    (object)[
        '_id' => 102,
        'user' => (object)['name' => 'Jane Smith', 'image' => 'https://i.pravatar.cc/150?img=2'],
        'rating' => 4.8,
        'totalReviews' => 85,
        'bio' => 'Full-stack developer with 10+ years of experience. I specialize in teaching modern web development with React and Node.js.',
        'hourlyRate' => 65,
        'subjects' => ['Web Development', 'JavaScript', 'React', 'Node.js']
    ],
    (object)[
        '_id' => 103,
        'user' => (object)['name' => 'Peter Jones', 'image' => 'https://i.pravatar.cc/150?img=3'],
        'rating' => null,
        'totalReviews' => 0,
        'bio' => 'Recent chemistry graduate eager to help students understand complex chemical concepts.',
        'hourlyRate' => 30,
        'subjects' => ['Chemistry', 'Organic Chemistry']
    ]
];

$selectedSubject = "Calculus"; // Example selected subject
@endphp

<div class="min-h-screen bg-white">
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <div class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight mb-2">
                Find Your Perfect Tutor
            </h1>
            <p class="text-gray-500">
                Browse through our verified tutors and book your next learning session
            </p>
        </div>

        <>
            <div class="flex items-center justify-between mb-4">
                <div class="text-sm text-gray-500">
                    {{ $selectedSubject ? "Showing lecturers for: {$selectedSubject}" : "All lecturers" }}
                </div>
                <a href="/browse" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium border h-9 px-3 bg-transparent hover:bg-gray-100">
                    All Majors
                </a>
            </div>

            <div class="rounded-xl border bg-white text-gray-900 shadow mb-8">
                <div class="flex flex-col space-y-1.5 p-6">
                    <h3 class="font-semibold tracking-tight text-lg flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                        Filter Tutors
                    </h3>
                </div>
                <div class="p-6 pt-0">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-3 h-4 w-4 text-gray-400"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input
                                placeholder="Search tutors..."
                                class="flex h-10 w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm pl-9"
                            />
                        </div>

                        <select class="flex h-10 items-center justify-between rounded-md border border-input bg-transparent px-3 py-2 text-sm">
                            <option value="all">All Subjects</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->name }}" @if($subject->name == $selectedSubject) selected @endif>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>

                        <input type="number" placeholder="Min rate ($)" class="flex h-10 w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm" />
                        <input type="number" placeholder="Max rate ($)" class="flex h-10 w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm" />
                    </div>
                </div>
            </div>

            @if(empty($filteredTutors))
                <div class="rounded-xl border bg-white text-gray-900 shadow">
                    <div class="p-6 text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-12 h-12 mx-auto text-gray-400 mb-4"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                        <h3 class="text-lg font-semibold mb-2">No tutors found</h3>
                        <p class="text-gray-500">Try adjusting your search criteria or browse all tutors</p>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($filteredTutors as $tutor)
                        <a href="/tutor/{{ $tutor->_id }}" class="block rounded-xl border bg-white text-gray-900 shadow h-full hover:shadow-lg transition-shadow cursor-pointer">
                            <div class="flex flex-col space-y-1.5 p-6 pb-4">
                                <div class="flex items-center gap-3">
                                    <span class="relative flex h-12 w-12 shrink-0 overflow-hidden rounded-full">
                                        <img class="aspect-square h-full w-full" src="{{ $tutor->user->image }}" />
                                    </span>
                                    <div class="flex-1">
                                        <h3 class="font-semibold tracking-tight text-lg">{{ $tutor->user->name }}</h3>
                                        <div class="flex items-center gap-2 mt-1">
                                            @if($tutor->rating && $tutor->rating > 0)
                                                <div class="flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-yellow-400 fill-yellow-400"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                    <span class="text-sm font-medium">{{ $tutor->rating }}</span>
                                                </div>
                                                <span class="text-sm text-gray-500">({{ $tutor->totalReviews }} reviews)</span>
                                            @else
                                                <span class="text-sm text-gray-500">New tutor</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6 pt-0 space-y-4">
                                <p class="text-sm text-gray-500 line-clamp-3">{{ $tutor->bio }}</p>
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium">Hourly Rate</span>
                                        <div class="flex items-center gap-1 text-lg font-bold text-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                            {{ $tutor->hourlyRate }}
                                        </div>
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium mb-2 block">Subjects</span>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach(array_slice($tutor->subjects, 0, 3) as $subject)
                                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-gray-100 text-gray-800">{{ $subject }}</div>
                                            @endforeach
                                            @if(count($tutor->subjects) > 3)
                                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold border-dashed">+{{ count($tutor->subjects) - 3 }} more</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium h-9 px-3 w-full bg-gray-900 text-white hover:bg-gray-800">
                                    View Profile
                                </button>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </>
    </div>
</div>

</body>
</html>