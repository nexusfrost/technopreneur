<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Become a Tutor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .text-primary { color: #3b82f6; }
        .bg-primary { background-color: #3b82f6; }
        .border-primary { border-color: #3b82f6; }
        .text-primary-foreground { color: #ffffff; }
    </style>
</head>
<body class="bg-white text-gray-800">

@php
// Dummy data
$subjectsByCategory = [
    'Mathematics' => [
        (object)['_id' => 1, 'name' => 'Calculus'],
        (object)['_id' => 2, 'name' => 'Statistics'],
        (object)['_id' => 7, 'name' => 'Algebra']
    ],
    'Science' => [
        (object)['_id' => 3, 'name' => 'Physics'],
        (object)['_id' => 4, 'name' => 'Chemistry'],
        (object)['_id' => 8, 'name' => 'Biology']
    ],
    'Technology' => [
        (object)['_id' => 5, 'name' => 'Web Development'],
        (object)['_id' => 6, 'name' => 'Data Science'],
        (object)['_id' => 9, 'name' => 'Python']
    ],
];
$availability = [
    ['day' => "Monday", 'startTime' => "", 'endTime' => "", 'enabled' => false],
    ['day' => "Tuesday", 'startTime' => "", 'endTime' => "", 'enabled' => false],
    ['day' => "Wednesday", 'startTime' => "", 'endTime' => "", 'enabled' => false],
    ['day' => "Thursday", 'startTime' => "", 'endTime' => "", 'enabled' => false],
    ['day' => "Friday", 'startTime' => "", 'endTime' => "", 'enabled' => false],
    ['day' => "Saturday", 'startTime' => "", 'endTime' => "", 'enabled' => false],
    ['day' => "Sunday", 'startTime' => "", 'endTime' => "", 'enabled' => false],
];
@endphp

<div class="min-h-screen bg-white">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight mb-2">Become a Tutor</h1>
            <p class="text-gray-500">
                Share your knowledge and help students achieve their learning goals
            </p>
        </div>

        <form action="/tutor-profile" method="POST" class="space-y-8">
            @csrf
            <div class="rounded-xl border bg-white text-gray-900 shadow">
                <div class="flex flex-col space-y-1.5 p-6">
                    <h3 class="font-semibold tracking-tight text-lg flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
                        Basic Information
                    </h3>
                    <p class="text-sm text-gray-500">
                        Tell us about yourself and your teaching background
                    </p>
                </div>
                <div class="p-6 pt-0 space-y-6">
                    <div>
                        <label for="name" class="text-sm font-medium leading-none block mb-2">Full Name</label>
                        <input id="name" name="name" placeholder="e.g., Jane Doe" class="flex h-10 w-full rounded-md border bg-transparent px-3 py-2 text-sm" />
                    </div>
                    <div>
                        <label for="bio" class="text-sm font-medium leading-none block mb-2">Bio</label>
                        <textarea id="bio" name="bio" placeholder="Tell students about yourself, your teaching style, and what makes you a great tutor..." class="flex min-h-[120px] w-full rounded-md border bg-transparent px-3 py-2 text-sm" required></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="education" class="text-sm font-medium leading-none block mb-2">Education</label>
                            <input id="education" name="education" placeholder="e.g., Bachelor's in Mathematics, MIT" class="flex h-10 w-full rounded-md border bg-transparent px-3 py-2 text-sm" required />
                        </div>
                        <div>
                            <label for="experience" class="text-sm font-medium leading-none block mb-2">Teaching Experience</label>
                            <input id="experience" name="experience" placeholder="e.g., 3 years of private tutoring" class="flex h-10 w-full rounded-md border bg-transparent px-3 py-2 text-sm" required />
                        </div>
                    </div>
                    <div>
                        <label for="hourlyRate" class="text-sm font-medium leading-none block mb-2">Hourly Rate ($)</label>
                        <input id="hourlyRate" name="hourlyRate" type="number" min="1" step="1" placeholder="25" class="flex h-10 w-full rounded-md border bg-transparent px-3 py-2 text-sm" required />
                    </div>
                </div>
            </div>

            <div class="rounded-xl border bg-white text-gray-900 shadow">
                <div class="flex flex-col space-y-1.5 p-6">
                    <h3 class="font-semibold tracking-tight text-lg">Subjects You Teach</h3>
                    <p class="text-sm text-gray-500">
                        Select all subjects you're qualified to teach
                    </p>
                </div>
                <div class="p-6 pt-0">
                    <div class="space-y-6">
                        @foreach($subjectsByCategory as $category => $categorySubjects)
                            <div>
                                <h3 class="font-semibold mb-3">{{ $category }}</h3>
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                    @foreach($categorySubjects as $subject)
                                        <div class="p-3 border rounded-lg cursor-pointer transition-colors hover:bg-gray-100">
                                            <div class="flex items-center justify-between">
                                                <label class="text-sm font-medium cursor-pointer flex-1">
                                                    <input type="checkbox" name="subjects[]" value="{{ $subject->name }}" class="hidden peer">
                                                    <span class="peer-checked:bg-primary peer-checked:text-primary-foreground peer-checked:border-primary block p-2 rounded-md">{{ $subject->name }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="rounded-xl border bg-white text-gray-900 shadow">
                <div class="flex flex-col space-y-1.5 p-6">
                    <h3 class="font-semibold tracking-tight text-lg flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        Availability
                    </h3>
                    <p class="text-sm text-gray-500">
                        Set your weekly availability (you can update this later)
                    </p>
                </div>
                <div class="p-6 pt-0">
                    <div class="space-y-4">
                        @foreach($availability as $index => $slot)
                            <div class="flex items-center gap-4">
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" id="day-{{ $index }}" name="availability[{{ $index }}][enabled]" class="h-4 w-4 rounded border-gray-300" />
                                    <label for="day-{{ $index }}" class="w-20 text-sm font-medium">{{ $slot['day'] }}</label>
                                </div>
                                <div class="flex items-center gap-2">
                                    <input type="time" name="availability[{{ $index }}][startTime]" class="flex h-10 w-32 rounded-md border bg-transparent px-3 py-2 text-sm" />
                                    <span class="text-gray-500">to</span>
                                    <input type="time" name="availability[{{ $index }}][endTime]" class="flex h-10 w-32 rounded-md border bg-transparent px-3 py-2 text-sm" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <a href="/dashboard" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium border h-10 px-4 py-2 bg-transparent hover:bg-gray-100">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium h-10 px-4 py-2 bg-gray-900 text-white hover:bg-gray-800">
                    Create Tutor Profile
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
