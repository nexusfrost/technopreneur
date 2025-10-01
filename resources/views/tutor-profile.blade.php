<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .text-primary { color: #3b82f6; }
    </style>
</head>
<body class="bg-white text-gray-800">

@php
// Dummy data for a single tutor
$tutor = (object)[
    '_id' => 101,
    'user' => (object)['name' => 'Dr. Evelyn Reed', 'image' => 'https://i.pravatar.cc/150?img=5'],
    'rating' => 4.9,
    'totalReviews' => 120,
    'isVerified' => true,
    'hourlyRate' => 50,
    'bio' => "With a Ph.D. in Applied Mathematics and over 15 years of university-level teaching experience, I specialize in making complex topics like calculus, differential equations, and linear algebra accessible and understandable. My goal is to build a strong foundational knowledge and problem-solving skills in my students.",
    'subjects' => ['Calculus I', 'Calculus II', 'Differential Equations', 'Linear Algebra', 'Statistics'],
    'education' => "Ph.D. in Applied Mathematics, Stanford University",
    'experience' => "15+ years as a University Professor",
    'availability' => [
        (object)['day' => 'Monday', 'startTime' => '10:00', 'endTime' => '17:00'],
        (object)['day' => 'Wednesday', 'startTime' => '10:00', 'endTime' => '17:00'],
        (object)['day' => 'Friday', 'startTime' => '10:00', 'endTime' => '14:00'],
    ]
];

$reviews = [
    (object)[
        '_id' => 1,
        'rating' => 5,
        'student' => (object)['name' => 'Alex Ray'],
        'comment' => "Dr. Reed is an amazing tutor! She explains concepts so clearly and has helped my grade improve significantly."
    ],
    (object)[
        '_id' => 2,
        'rating' => 5,
        'student' => (object)['name' => 'Mia Wallace'],
        'comment' => "Couldn't have passed Calculus II without her. Highly recommended!"
    ],
    (object)[
        '_id' => 3,
        'rating' => 4,
        'student' => (object)['name' => 'Ben Carter'],
        'comment' => null
    ]
];
@endphp

<div class="min-h-screen bg-white">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <a href="/browse" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium h-10 px-4 py-2 mb-6 hover:bg-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Back to Browse
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="rounded-xl border bg-white text-gray-900 shadow">
                    <div class="p-6">
                        <div class="flex items-start gap-4">
                            <span class="relative flex h-20 w-20 shrink-0 overflow-hidden rounded-full">
                                <img class="aspect-square h-full w-full" src="{{ $tutor->user->image }}" />
                            </span>
                            <div class="flex-1">
                                <h3 class="font-semibold tracking-tight text-2xl mb-2">{{ $tutor->user->name }}</h3>
                                <div class="flex items-center gap-4 mb-3">
                                    @if($tutor->rating > 0)
                                        <div class="flex items-center gap-2">
                                            <div class="flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-yellow-400"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                <span class="font-semibold">{{ $tutor->rating }}</span>
                                            </div>
                                            <span class="text-gray-500">({{ $tutor->totalReviews }} reviews)</span>
                                        </div>
                                    @else
                                        <span class="text-gray-500">New tutor</span>
                                    @endif
                                    @if($tutor->isVerified)
                                        <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-gray-100 text-gray-800 gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                            Verified
                                        </div>
                                    @endif
                                </div>
                                <div class="flex items-center gap-1 text-2xl font-bold text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                    {{ $tutor->hourlyRate }}
                                    <span class="text-base font-normal text-gray-500">/hour</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 pt-0 space-y-6">
                        <div>
                            <h3 class="font-semibold mb-2">About</h3>
                            <p class="text-gray-500 leading-relaxed">{{ $tutor->bio }}</p>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-3">Subjects</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($tutor->subjects as $subject)
                                    <div class="inline-flex items-center rounded-md border px-2.5 py-0.5 text-sm font-semibold">{{ $subject }}</div>
                                @endforeach
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="font-semibold mb-2 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
                                    Education
                                </h3>
                                <p class="text-gray-500">{{ $tutor->education }}</p>
                            </div>
                            <div>
                                <h3 class="font-semibold mb-2 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                                    Experience
                                </h3>
                                <p class="text-gray-500">{{ $tutor->experience }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border bg-white text-gray-900 shadow">
                    <div class="p-6">
                        <h3 class="font-semibold tracking-tight text-lg">Reviews</h3>
                        <p class="text-sm text-gray-500">What students say about this tutor</p>
                    </div>
                    <div class="p-6 pt-0">
                        @if(empty($reviews))
                            <p class="text-gray-500 text-center py-8">No reviews yet. Be the first to book and review!</p>
                        @else
                            <div class="space-y-4">
                                @foreach($reviews as $review)
                                    <div class="border-b pb-4 last:border-b-0">
                                        <div class="flex items-center gap-2 mb-2">
                                            <div class="flex items-center gap-1">
                                                @for($i = 0; $i < 5; $i++)
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 {{ $i < $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                @endfor
                                            </div>
                                            <span class="font-medium">{{ $review->student->name }}</span>
                                        </div>
                                        @if($review->comment)
                                            <p class="text-gray-500">{{ $review->comment }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-xl border bg-white text-gray-900 shadow">
                    <div class="p-6">
                        <h3 class="font-semibold tracking-tight text-lg">Book a Session</h3>
                        <p class="text-sm text-gray-500">Schedule your learning session with {{ $tutor->user->name }}</p>
                    </div>
                    <div class="p-6 pt-0">
                        <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium h-11 px-8 w-full bg-gray-900 text-white hover:bg-gray-800">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            Book Now
                        </button>
                    </div>
                </div>

                <div class="rounded-xl border bg-white text-gray-900 shadow">
                    <div class="p-6">
                        <h3 class="font-semibold tracking-tight text-lg flex items-center gap-2">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                             Availability
                        </h3>
                    </div>
                    <div class="p-6 pt-0">
                        @if(empty($tutor->availability))
                             <p class="text-gray-500 text-sm">No availability set</p>
                        @else
                            <div class="space-y-2">
                                @foreach($tutor->availability as $slot)
                                    <div class="flex justify-between text-sm">
                                        <span class="font-medium">{{ $slot->day }}</span>
                                        <span class="text-gray-500">{{ $slot->startTime }} - {{ $slot->endTime }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>