<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Profile</title>
    <!-- Alpine.js is REQUIRED for the modal logic -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --background: #F0EBE2;
            --foreground: #1A2A57;
            --primary: #B83A3F;
            --primary-foreground: #ffffff;
            --muted: #e6e3dd;
            --muted-foreground: #2E4980;
            --border: #6A8094;
        }

        body {
            background-color: var(--muted);
            color: var(--foreground);
        }
        .card {
            background-color: var(--background);
            border-color: var(--border);
        }
        /* Custom Input Styling to match theme */
        .input-field {
            background-color: transparent;
            border-color: var(--border);
            color: var(--foreground);
        }
        .input-field:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(184, 58, 63, 0.2);
        }
    </style>
</head>
<body class="bg-[var(--muted)] text-[var(--foreground)]">

<!--
    ADDED x-data HERE
    We store the hourly rate to calculate the total price dynamically in the modal
-->
<div class="min-h-screen"
     x-data="{
        bookModalOpen: false,
        hourlyRate: {{ $tutorProfile->hourly_rate ?? 0 }},
        duration: 1
     }">

    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <a href="{{ route('browse-tutors') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium h-10 px-4 py-2 mb-6 hover:bg-[var(--background)] border border-transparent hover:border-[var(--border)] transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Back to Browse
        </a>


            @if (session('status'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md mb-6" role="alert">
                    <p>{{ session('status') }}</p>
                </div>
            @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="rounded-xl border card shadow">
                    <div class="p-6">
                        <div class="flex items-start gap-4">
                            <span class="relative flex h-20 w-20 shrink-0 overflow-hidden rounded-full">
                                <img class="aspect-square h-full w-full" src="https://i.pravatar.cc/150?img=5" />
                            </span>
                            <div class="flex-1">
                                <h3 class="font-semibold tracking-tight text-2xl mb-2">{{ $tutorProfile->name }}</h3>
                                <div class="flex items-center gap-4 mb-3">
                                    <div class="flex items-center gap-2">
                                        <div class="flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-yellow-400"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                            {{-- Added number_format check --}}
                                            <span class="font-semibold">{{ isset($avgRating) ? number_format($avgRating,1) : "New" }}</span>
                                        </div>
                                        <span class="text-[var(--muted-foreground)]">({{ $ratingsCount ?? 0 }} reviews)</span>
                                    </div>
                                    <div class="inline-flex items-center rounded-full border border-[var(--border)]/50 px-2.5 py-0.5 text-xs font-semibold bg-[var(--muted)] text-[var(--muted-foreground)] gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                        Verified
                                    </div>
                                </div>
                                <div class="flex items-center gap-1 text-2xl font-bold text-[var(--primary)]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                    {{ $tutorProfile->hourly_rate }}
                                    <span class="text-base font-normal text-[var(--muted-foreground)]">/hour</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 pt-0 space-y-6">
                        <div>
                            <h3 class="font-semibold mb-2">About</h3>
                            <p class="text-[var(--muted-foreground)] leading-relaxed">{{ $tutorProfile->bio }}</p>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-3">Subjects</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($tutorProfile->subjects as $subject)
                                    <div class="inline-flex items-center rounded-md border border-[var(--border)]/80 px-2.5 py-0.5 text-sm font-semibold bg-[var(--primary)] text-white">{{ $subject->name }}</div>
                                @endforeach
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="font-semibold mb-2 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-[var(--muted-foreground)]"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
                                    Education
                                </h3>
                                <p class="text-[var(--muted-foreground)]">{{ $tutorProfile->education }}</p>
                            </div>
                            <div>
                                <h3 class="font-semibold mb-2 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-[var(--muted-foreground)]"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                                    Experience
                                </h3>
                                <p class="text-[var(--muted-foreground)]">{{ $tutorProfile->teaching_experience }} years</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border card shadow">
                    <div class="p-6">
                        <h3 class="font-semibold tracking-tight text-lg">Reviews</h3>
                        <p class="text-sm text-[var(--muted-foreground)]">What students say about this tutor</p>
                    </div>
                    <div class="p-6 pt-0">
                        <div class="space-y-4">
                            @foreach ($ratings as $rating)
                                <div class="border-b border-[var(--border)]/50 pb-4 last:border-b-0">
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="flex items-center gap-1">
                                            @foreach(range(1,5) as $i)
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 {{ $i <= $rating->rating ? 'text-yellow-400' : 'text-gray-300' }}"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                            @endforeach
                                        </div>
                                        <span class="font-medium">{{ $rating->student->name }}</span>
                                    </div>
                                    <p class="text-[var(--muted-foreground)]">{{ $rating->review }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-xl border card shadow top-6">
                    <div class="p-6">
                        <h3 class="font-semibold tracking-tight text-lg">Book a Session</h3>
                        <p class="text-sm text-[var(--muted-foreground)]">Schedule your learning session with {{ $tutorProfile->name }}</p>
                    </div>
                    <div class="p-6 pt-0">
                        <!-- ADDED CLICK EVENT -->
                        <button @click="bookModalOpen = true" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium h-11 px-8 w-full bg-[var(--primary)] text-[var(--primary-foreground)] hover:opacity-90 transition-opacity">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            Book Now
                        </button>
                    </div>
                </div>

                <div class="rounded-xl border card shadow">
                    <div class="p-6">
                        <h3 class="font-semibold tracking-tight text-lg flex items-center gap-2">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-[var(--muted-foreground)]"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                             Availability
                        </h3>
                    </div>
                    <div class="p-6 pt-0">
                        <div class="space-y-2">
                            @foreach ($availabilities as $availability)
                                <div class="flex justify-between text-sm">
                                    <span class="font-medium">{{ $availability->day_of_week }}</span>
                                    <span class="text-[var(--muted-foreground)]">
                                        {{ \Carbon\Carbon::parse($availability->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($availability->end_time)->format('H:i') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BOOKING MODAL -->
    <div x-show="bookModalOpen"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 md:p-10"
         style="display: none;">

        <!-- Backdrop -->
        <div @click="bookModalOpen = false" class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>

        <!-- Modal Content -->
        <div class="relative w-full max-w-md bg-[var(--background)] rounded-2xl shadow-xl overflow-hidden border border-[var(--border)]">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-xl font-bold tracking-tight">Book a Session</h2>
                        <p class="text-sm text-[var(--muted-foreground)]">with {{ $tutorProfile->name }}</p>
                    </div>
                    <button @click="bookModalOpen = false" class="text-[var(--muted-foreground)] hover:text-[var(--foreground)]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>

                {{-- Replace 'reservations.store' with your actual route --}}
                <form action="{{ route('reservations.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="tutor_profile_id" value="{{ $tutorProfile->id }}">

                    <div>
                        <label class="block text-sm font-medium mb-1">Date</label>
                        <input type="date" name="reservation_date" required
                               class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Start Time</label>
                        <input type="time" name="start_time" required
                               class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Duration (Hours)</label>
                        <input type="number" name="duration" min="1" max="8" x-model="duration"
                               class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm">
                    </div>

                    <!-- Dynamic Price Calculation -->
                    <div class="bg-[var(--muted)] p-3 rounded-lg flex justify-between items-center border border-[var(--border)]/50">
                        <span class="text-sm font-medium">Estimated Total</span>
                        <span class="text-lg font-bold text-[var(--primary)]" x-text="'$' + (duration * hourlyRate).toFixed(2)"></span>
                    </div>

                    <div class="flex gap-3 mt-4">
                        <button type="button" @click="bookModalOpen = false" class="flex-1 h-10 rounded-md border border-[var(--border)] text-sm font-medium hover:bg-[var(--muted)] transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 h-10 rounded-md bg-[var(--primary)] text-white text-sm font-medium hover:opacity-90 transition-opacity">
                            Confirm Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

</body>
</html>
