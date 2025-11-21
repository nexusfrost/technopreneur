<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TutorHub - Dashboard</title>
    <!-- Alpine.js for interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- Tailwind CSS for styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* * =================================================================
         * CUSTOMIZED COLOR PALETTE
         * =================================================================
         */
        :root {
            --background: #EEEBE4; /* Off-white/Cream */
            --foreground: #212C68; /* Dark Blue */
            --primary: #B83A42;    /* Red */
            --primary-foreground: #ffffff; /* White */
            --muted: #e6e3dd;      /* Slightly darker cream */
            --muted-foreground: #35477C; /* Medium Blue */
            --border: #698196;     /* Desaturated Blue/Grey */
        }

        /* Basic input field styling to use custom variables */
        .input-field {
            border-color: var(--border);
            background-color: transparent;
        }
        .input-field:focus {
            --tw-ring-color: var(--primary);
            border-color: var(--primary);
        }
        .input-field:disabled {
            cursor: not-allowed;
            background-color: #e6e3dd;
            opacity: 0.7;
        }
    </style>
</head>
<body class="bg-[var(--muted)] text-[var(--foreground)]">

    {{--
        This Alpine component now only manages the modal states.
        The 'hasTutorProfile' logic is now handled by Blade.
        Note: In a real app, you would pass $user and $tutorProfile from your route.
        For this example, we'll use Auth::user() and check for the tutor profile relationship.
    --}}
    @php
        $user = Auth::user();
        $tutorProfile = $user->tutorProfile;
    @endphp

    <div class="min-h-screen"
         x-data="{
             userEditOpen: false,
             tutorEditOpen: false,
             tutorFormOpen: false,
             activeTab: 'bookings',
             sessionModalOpen: false,
             finalPaymentModalOpen: false,
             activeTab: 'bookings',
             currentSession: { id: '', link: '', name: '' } ,
             paymentModalOpen: false,
             currentPayment: { id: '', amount: 0, total: 0 },
             ratingModalOpen: {{ isset($pendingRatingSession) && $pendingRatingSession ? 'true' : 'false' }},
             ratingScore: 0,
             ratingHover: 0,
             rejectModalOpen: false,
             currentRejection: { id: '', name: '' },



         }"
         @keydown.escape.window="tutorFormOpen = false; userEditOpen = false; tutorEditOpen = false">

        <div class="container mx-auto px-4 py-8 max-w-6xl">

            <!-- Session Messages & Errors -->
            @if (session('status'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md mb-6" role="alert">
                    <p>{{ session('status') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md mb-6" role="alert">
                    <p class="font-bold">Please correct the errors below:</p>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <!-- Header -->
            <div class="flex flex-wrap justify-between items-center mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">Dashboard</h1>
                    <p class="text-[var(--muted-foreground)] mt-1">
                        Welcome back, {{ $user->name }}!
                    </p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('chat') }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium border border-[var(--border)] bg-[var(--background)] hover:bg-[var(--muted)] h-10 px-4 py-2 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                        Messages
                    </a>
                    <button @click="userEditOpen = true" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium border border-[var(--border)] bg-[var(--background)] hover:bg-[var(--muted)] h-10 px-4 py-2 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Edit Profile
                    </button>

                    <a href={{ route('browse-tutors') }} class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium border border-[var(--border)] bg-[var(--background)] hover:bg-[var(--muted)] h-10 px-4 py-2 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                        Browse Tutors
                    </a>



                    @if (!$tutorProfile)
                        <button @click="tutorFormOpen = true" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium bg-[var(--primary)] text-[var(--primary-foreground)] hover:opacity-90 h-10 px-4 py-2 transition-colors">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
                            Become a Tutor
                        </button>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium h-10 px-4 py-2 transition-colors bg-[var(--primary)] text-[var(--primary-foreground)] hover:opacity-90">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        Log Out
                    </button>
                </form>
                                </div>
            </div>

            <!-- Tabs -->
            <div class="space-y-6">
                <div class="flex justify-center min-w-max">
                    <div class="inline-flex h-10 items-center justify-center rounded-lg p-1 text-[var(--muted-foreground)] min-w-max bg-amber-50 sm:w-auto w-full">
                        <button @click="activeTab = 'bookings'" :class="{'bg-[var(--background)] text-[var(--foreground)] shadow-sm': activeTab === 'bookings'}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1.5 text-sm font-medium ring-offset-background transition-all sm:w-auto w-full">My Bookings</button>
                        <button @click="activeTab = 'tutor'" :class="{'bg-[var(--background)] text-[var(--foreground)] shadow-sm': activeTab === 'tutor'}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1.5 text-sm font-medium ring-offset-background transition-all w-full sm:w-auto">Tutor Dashboard</button>
                    </div>
                </div>

                <!-- My Bookings Content -->
                <div x-show="activeTab === 'bookings'" class="space-y-6">
                    <div class="rounded-lg border border-[var(--border)]/50 bg-[var(--background)] shadow-sm">
                        <div class="p-6">
                            @if (!$reservations)
                                <div class="text-center py-8">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-12 h-12 mx-auto text-[var(--muted-foreground)] mb-4"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                    <p class="text-[var(--muted-foreground)] mb-4">No bookings yet</p>
                                    <a href="#" class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-[var(--primary)] text-[var(--primary-foreground)] hover:opacity-90 h-10 px-4 py-2 transition-colors">
                                        Find a Tutor
                                    </a>
                                </div>
                            @else
                                <div class="space-y-4">
                                    <div>
                                        <h1 class=" mb-6 text-xl font-bold">Upcoming Sessions</h1>
                                    </div>
                                @foreach($reservations as $booking)
                                    <div class="flex flex-col md:flex-row md:items-center justify-between p-4 border shadow rounded-lg gap-4 bg-orange-50">
                                        <div class="flex flex-1">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <h3 class="font-semibold">
                                                    Tutoring with {{ $booking->student->name }}
                                                </h3>

                                                {{-- Status Badge --}}
                                                @php
                                                    $statusColors = [
                                                        'confirmed' => 'bg-green-100 text-green-800',
                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                        'completed' => 'bg-blue-100 text-blue-800',
                                                        'cancelled' => 'bg-red-100 text-red-800',
                                                    ];
                                                    $badgeClass = $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800';
                                                @endphp
                                                <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 {{ $badgeClass }}">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </div>

                                            <div class="flex flex-wrap items-center gap-4 text-sm text-muted-foreground">
                                                <span class="flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                                    {{ $booking->date }}
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                                    {{ $booking->start_time }} - {{ $booking->end_time }}
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                                    {{ $booking->price }}
                                                </span>
                                            </div>
                                        </div>

                                        </div>

                                        <div class="flex gap-2">
                                            @if($booking->status === 'unpaid')
                                                {{-- Confirm Action --}}
                                                <a href="{{ $booking->meeting_link }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium border border-input  bg-blue-950 text-white h-9 px-3">
                                                    Join Session
                                                </a>
                                                    {{-- End Session --}}
                                                    <form id="complete-form-{{ $booking->id }}" action="" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="completed">
                                                        <button type="button" @click="endSession('{{ $booking->id }}')" class="inline-flex items-center justify-center rounded-md text-sm font-medium border bg-red-600 text-white h-9 px-3">
                                                            End Session
                                                        </button>
                                                    </form>

                                            @elseif ($booking->status == 'accepted')
                                                    <button
                                                        @click="
                                                            paymentModalOpen = true;
                                                            currentPayment = {
                                                                id: '{{ $booking->id }}',
                                                                amount: '{{ number_format($booking->price / 2, 2) }}',
                                                                total: '{{ $booking->price }}'
                                                            }
                                                        "
                                                        class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-blue-950 text-[var(--primary-foreground)] hover:opacity-90 h-9 px-3 transition-colors">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                                                        Pay Down Payment
                                                    </button>
                                                    <form action="{{ route('cancel',$booking) }}" method="post">
                                                        @csrf
                                                        @method('patch')
                                                        <button type='submit'  class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-red-600 text-[var(--primary-foreground)] hover:opacity-90 h-9 px-3 transition-colors">
                                                            Cancel
                                                        </button>

                                                    </form>


                                            @elseif($booking->status === 'ongoing')
                                                {{-- Start Session --}}
                                                @if($booking->meeting_link)
                                                    <a href="{{ $booking->meeting_link }}" target="_blank" rel="noopener noreferrer" class=" bg-blue-950 text-white inline-flex items-center justify-center rounded-md text-sm font-medium bg-primary text-primary-foreground hover:bg-primary/90 h-9 px-3">
                                                        Join Session
                                                    </a>
                                                    {{-- End Session --}}

                                                    <button
                                                        @click="
                                                            finalPaymentModalOpen = true;
                                                            currentPayment = {
                                                                id: '{{ $booking->id }}',
                                                                amount: '{{ number_format($booking->price / 2, 2) }}',
                                                                total: '{{ $booking->price }}'
                                                            }
                                                        "
                                                        class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-red-600 text-white hover:opacity-90 h-9 px-3 transition-colors">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                                        Pay Remaining Balance
                                                    </button>
                                                @else
                                                    <span
                                                        class="inline-flex items-center justify-center rounded-md text-sm font-medium text-black hover:opacity-90 h-9 px-3 transition-colors">
                                                        Waiting for Tutor
                                                    </span>
                                                @endif


                                            @elseif ($booking->status == 'done' || $booking->status == 'cancelled')
                                                <h1>Finished</h1>

                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @endif
                        </div>
                    </div>
                </div>

                {{-- tutor Dashboard --}}
                <div x-show="activeTab === 'tutor'" class="space-y-6  rounded-lg border border-[var(--border)]/50 bg-[var(--background)] shadow-sm" style="display: none;">
                    <div>
                        @if ($tutorProfile)
                            <div class="space-y-6 m-6">
                                <div class="flex justify-end">
                                    <button @click="tutorEditOpen = true" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium border border-[var(--border)] bg-[var(--background)] hover:bg-[var(--muted)] h-10 px-4 py-2 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                        Edit Tutor Profile
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                    <div class="rounded-xl border bg-card text-card-foreground shadow-sm text-center bg-amber-50 flex flex-col items-center justify-center">
                                        <div class="p-6 flex flex-col space-y-1.5 pb-3">
                                            <h3 class="font-semibold tracking-tight text-sm">Lifetime Earnings</h3>
                                        </div>
                                        <div class="p-6 pt-0">
                                            <div class="text-2xl font-bold">
                                                ${{ number_format($totalEarnings, 2) }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="rounded-xl border bg-card text-card-foreground shadow-sm text-center bg-amber-50 flex flex-col items-center justify-center">
                                        <div class="p-6 flex flex-col space-y-1.5 pb-3">
                                            <h3 class="font-semibold tracking-tight text-sm">Rating</h3>
                                        </div>
                                        <div class="p-6 pt-0">
                                            <div class="flex flex-col items-center gap-2 justify-center">
                                                <div class="flex items-center text-center gap-1">
                                                    <div class="text-2xl font-bold">{{ number_format( $tutorRatings->average('rating'),2) ?? 0 }}</div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-400 fill-yellow-400"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                                </div>
                                                <span class="text-sm text-muted-foreground">({{ $tutorRatings->count() ?? 0 }} reviews)</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="rounded-xl border bg-card text-card-foreground shadow-sm text-center bg-amber-50 flex flex-col items-center justify-center">
                                        <div class="p-6 flex flex-col space-y-1.5 pb-3">
                                            <h3 class="font-semibold tracking-tight text-sm">Total Finished Sessions</h3>
                                        </div>
                                        <div class="p-6 pt-0">
                                            <div class="text-2xl font-bold">
                                                {{ $tutorBookings }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="rounded-xl border bg-card text-card-foreground shadow-sm text-center bg-amber-50">
                                        <div class="p-6 flex flex-col space-y-1.5 pb-3">
                                            <h3 class="font-semibold tracking-tight text-sm">Available Balance</h3>
                                        </div>
                                        <div class="p-6 pt-0 ">
                                            <div class="flex items-center flex-col gap-3 justify-center ">
                                                <div class="text-2xl font-bold">${{ number_format(auth()->user()->tutorProfile->balance ?? 0, 2) }}</div>
                                                <form action="{{ route('cashout') }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        @if((auth()->user()->tutorProfile->balance ?? 0) <= 0) disabled @endif
                                                        class="inline-flex items-center justify-center rounded-md text-white text-sm font-medium bg-red-600 border-input bg-background  h-9 px-3 disabled:opacity-50">
                                                        Cashout
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- tutor sessions --}}
                            <div class="m-6 space-y-4">
                                @foreach($tutorReservations as $booking)
                                    <div class="flex flex-col md:flex-row md:items-center justify-between p-4 border shadow rounded-lg gap-4 bg-orange-50">
                                        <div class="flex flex-1">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <h3 class="font-semibold">
                                                    Tutoring with {{ $booking->student->name }}
                                                </h3>

                                                {{-- Status Badge --}}
                                                @php
                                                    $statusColors = [
                                                        'accepted' => 'bg-green-100 text-green-800',
                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                        'done' => 'bg-blue-100 text-blue-800',
                                                        'cancelled' => 'bg-red-100 text-red-800',
                                                        'rejected' => 'bg-red-100 text-red-800',
                                                    ];
                                                    $badgeClass = $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800';
                                                @endphp
                                                <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 {{ $badgeClass }}">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </div>

                                            <div class="flex flex-wrap items-center gap-4 text-sm text-muted-foreground">
                                                <span class="flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                                    {{ $booking->date }}
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                                    {{ $booking->start_time }} - {{ $booking->end_time }}
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                                    {{ $booking->price }}
                                                </span>
                                            </div>
                                        </div>

                                        </div>

                                        <div class="flex gap-2 items-center">
                                            @if($booking->status === 'unpaid')
                                                    <a href="{{ $booking->meeting_link }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium border border-input bg-blue-950 text-white h-9 px-3">
                                                        Join Session
                                                    </a>

                                            @elseif($booking->status === 'ongoing')
                                                {{-- Start Session --}}
                                                @if($booking->meeting_link)
                                                    <a href="{{ $booking->meeting_link }}" target="_blank" rel="noopener noreferrer" class=" bg-blue-950 text-white inline-flex items-center justify-center rounded-md text-sm font-medium bg-primary text-primary-foreground hover:bg-primary/90 h-9 px-3">
                                                        Join Session
                                                    </a>


                                                @else
                                                    <button
                                                        @click="
                                                            sessionModalOpen = true;
                                                            currentSession = {
                                                                id: '{{ $booking->id }}',
                                                                link: '{{ $booking->meeting_link }}',
                                                                name: '{{ $booking->student->name ?? 'Student' }}'
                                                            }
                                                        "
                                                        class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-green-600 text-[var(--primary-foreground)] hover:opacity-90 h-9 px-3 transition-colors">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                                        Start Session
                                                    </button>
                                                @endif

                                                {{-- End Session --}}
                                                <button
                                                    @click="
                                                        finalPaymentModalOpen = true;
                                                        currentPayment = {
                                                            id: '{{ $booking->id }}',
                                                            amount: '{{ number_format($booking->price / 2, 2) }}',
                                                            total: '{{ $booking->price }}'
                                                        }
                                                    "
                                                    class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-red-600 text-white hover:opacity-90 h-9 px-3 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                                    Pay Remaining Balance
                                                </button>

                                            @elseif ($booking->status == 'done' || $booking->status == 'cancelled')
                                                <h1>Finished</h1>

                                            @elseif ($booking->status == 'pending')
                                                <form action="{{ route('accept',$booking) }}" method="post">
                                                    @csrf
                                                    @method('patch')
                                                    <button type='submit' class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-green-600 text-[var(--primary-foreground)] hover:opacity-90 h-9 px-3 transition-colors">
                                                        Accept
                                                    </button>

                                                </form>
                                                <button type="button"
                                                    @click="
                                                        rejectModalOpen = true;
                                                        currentRejection = {
                                                            id: '{{ $booking->id }}',
                                                            name: @js($booking->student->name ?? 'Student')
                                                        }
                                                    "
                                                    class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-red-600 text-white hover:bg-red-700 h-9 px-3 transition-colors">
                                                    Reject
                                                </button>

                                            @elseif($booking->status == 'accepted')
                                                <button
                                                    @click="
                                                        paymentModalOpen = true;
                                                        currentPayment = {
                                                            id: '{{ $booking->id }}',
                                                            amount: '{{ number_format($booking->price / 2, 2) }}',
                                                            total: '{{ $booking->price }}'
                                                        }
                                                    "
                                                    class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-blue-950 text-[var(--primary-foreground)] hover:opacity-90 h-9 px-3 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                                                    Pay Down Payment
                                                </button>
                                                <form action="{{ route('cancel',$booking) }}" method="post">
                                                    @csrf
                                                    @method('patch')
                                                    <button type='submit'  class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-red-600 text-[var(--primary-foreground)] hover:opacity-90 h-9 px-3 transition-colors">
                                                        Cancel
                                                    </button>

                                                </form>



                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div>
                                <div class="rounded-lg border border-[var(--border)]/50 bg-[var(--background)] shadow-sm">
                                    <div class="p-6">
                                        <div class="text-center py-8">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-12 h-12 mx-auto text-[var(--muted-foreground)] mb-4"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
                                            <p class="font-semibold text-lg mb-2">You are not a tutor yet</p>
                                            <p class="text-[var(--muted-foreground)] mb-4">Create your tutor profile to start connecting with students.</p>
                                            <button @click="tutorFormOpen = true" class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-[var(--primary)] text-[var(--primary-foreground)] hover:opacity-90 h-10 px-4 py-2 transition-colors">
                                                Become a Tutor
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

        {{-- link meeting modal --}}
        <!-- "Start Session" MODAL -->
<div x-show="sessionModalOpen"
     x-transition:enter="ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 md:p-10"
     style="display: none;">

    <!-- Backdrop -->
    <div @click="sessionModalOpen = false" class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>

    <!-- Modal Content -->
    <div x-show="sessionModalOpen"
         @click.stop
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="relative w-full max-w-lg bg-[var(--muted)] rounded-2xl shadow-xl overflow-hidden">

        <!-- Close Button -->
        <button @click="sessionModalOpen = false" class="absolute top-4 right-4 text-[var(--muted-foreground)] hover:text-[var(--foreground)] transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>

        <div class="p-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold tracking-tight mb-2">Start Session</h1>
                <p class="text-[var(--muted-foreground)] text-sm">
                    You are about to start a session with <span class="font-semibold text-[var(--foreground)]" x-text="currentSession.name"></span>.
                </p>
            </div>

            <!-- Dynamic Form: Action updates based on ID -->
            <!-- Note: Change 'reservations.update' to your actual route name if different -->
            <form :action="'/update-link/' + currentSession.id" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <!-- Hidden Input to set status to confirmed/started -->

                <div class="rounded-xl border border-[var(--border)]/50 bg-[var(--background)] shadow-sm">
                    <div class="p-6 space-y-4">
                        <div>
                            <label for="meeting_link" class="text-sm font-medium leading-none block mb-2">Meeting Link (Zoom/Meet)</label>
                            <div class="relative">
                                <input id="meeting_link"
                                       name="meeting_link"
                                       type="url"
                                       x-model="currentSession.link"
                                       placeholder="https://zoom.us/j/..."
                                       class="flex h-10 w-full rounded-md border input-field pl-10 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2"
                                       required />
                                <!-- Icon inside input -->
                                <div class="absolute left-3 top-2.5 text-[var(--muted-foreground)]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                                </div>
                            </div>
                            <p class="text-xs text-[var(--muted-foreground)] mt-2">
                                Ensure this link is accessible to the student.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4 pt-2">
                    <button type="button" @click="sessionModalOpen = false" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium border border-[var(--border)] h-10 px-4 py-2 bg-transparent hover:bg-[var(--background)] transition-colors">
                        Cancel
                    </button>

                    <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium h-10 px-6 py-2 bg-green-600 text-[var(--primary-foreground)] hover:opacity-90 transition-opacity shadow-sm">
                        Launch Session
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

        {{-- DP modal --}}
        <!-- "Down Payment" MODAL -->
<div x-show="paymentModalOpen"
     x-transition:enter="ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 flex items-start justify-center p-4 sm:p-6 md:p-10"
     style="display: none;">

    <!-- Backdrop -->
    <div @click="paymentModalOpen = false" class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>

    <!-- Modal Content -->
    <div x-show="paymentModalOpen"
         @click.stop
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="relative w-full max-w-md bg-[var(--muted)] rounded-2xl shadow-xl overflow-hidden border border-[var(--border)]">

        <!-- Close Button -->
        <button @click="paymentModalOpen = false" class="absolute top-4 right-4 text-[var(--muted-foreground)] hover:text-[var(--foreground)] transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>

        <div class="p-8">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold tracking-tight mb-1">Down Payment</h1>
                <p class="text-[var(--muted-foreground)] text-sm">
                    Scan to pay the 50% deposit to secure your slot.
                </p>
            </div>

            <!-- Payment Summary Card -->
            <div class="bg-[var(--background)] border border-[var(--border)]/50 rounded-lg p-4 mb-6 flex justify-between items-center shadow-sm">
                <div class="text-left">
                    <p class="text-xs text-[var(--muted-foreground)] uppercase tracking-wide font-semibold">Total Price</p>
                    <p class="font-medium" x-text="'$' + currentPayment.total"></p>
                </div>
                <div class="h-8 w-px bg-[var(--border)]"></div>
                <div class="text-right">
                    <p class="text-xs text-[var(--primary)] uppercase tracking-wide font-bold">To Pay Now</p>
                    <p class="text-xl font-bold text-[var(--primary)]" x-text="'$' + currentPayment.amount"></p>
                </div>
            </div>

            <!-- QR Code Container -->
            <div class="flex flex-col items-center justify-center space-y-4 mb-8">
                <div class="p-3 bg-white rounded-xl shadow-md">
                    <!-- Placeholder QR Code Generator -->
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=TutorHubPayment"
                         alt="Payment QR Code"
                         class="w-40 h-40 object-contain mix-blend-multiply">
                </div>
                <p class="text-xs text-center text-[var(--muted-foreground)] max-w-[200px]">
                    Supported: QRIS
                </p>
            </div>

            <!-- Confirm Form -->
            <!-- Adjust the route '/reservations/'... to match your update route -->
            <form :action="'/dp/' + currentPayment.id" method="POST">
                @csrf
                @method('PATCH')

                <!-- Logic: Set status to 'half done' to indicate deposit paid -->
                <button type="submit" class="w-full inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-bold h-11 px-6 bg-green-700 text-white hover:bg-green-800 transition-colors shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    I Have Sent Payment
                </button>
            </form>

            <div class="mt-4 text-center">
                 <button @click="paymentModalOpen = false" class="text-sm text-[var(--muted-foreground)] hover:underline">Cancel Payment</button>
            </div>
        </div>
    </div>
</div>

{{-- final payment modal --}}
<!-- "Final Payment" MODAL -->
<div x-show="finalPaymentModalOpen"
     x-transition:enter="ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 flex items-start justify-center p-4 sm:p-6 md:p-10"
     style="display: none;">

    <!-- Backdrop -->
    <div @click="finalPaymentModalOpen = false" class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>

    <!-- Modal Content -->
    <div x-show="finalPaymentModalOpen"
         @click.stop
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="relative w-full max-w-md bg-[var(--muted)] rounded-2xl shadow-xl overflow-hidden border border-[var(--border)]">

        <!-- Close Button -->
        <button @click="finalPaymentModalOpen = false" class="absolute top-4 right-4 text-[var(--muted-foreground)] hover:text-[var(--foreground)] transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>

        <div class="p-8">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold tracking-tight mb-1">Final Payment</h1>
                <p class="text-[var(--muted-foreground)] text-sm">
                    Complete your payment to finish the session.
                </p>
            </div>

            <!-- Payment Summary Card -->
            <div class="bg-[var(--background)] border border-[var(--border)]/50 rounded-lg p-4 mb-6 flex justify-between items-center shadow-sm">
                <div class="text-left">
                    <p class="text-xs text-[var(--muted-foreground)] uppercase tracking-wide font-semibold">Total Price</p>
                    <p class="font-medium" x-text="'$' + currentPayment.total"></p>
                </div>
                <div class="h-8 w-px bg-[var(--border)]"></div>
                <div class="text-right">
                    <p class="text-xs text-blue-800 uppercase tracking-wide font-bold">Remaining Due</p>
                    <p class="text-xl font-bold text-blue-800" x-text="'$' + currentPayment.amount"></p>
                </div>
            </div>

            <!-- QR Code Container -->
            <div class="flex flex-col items-center justify-center space-y-4 mb-8">
                <div class="p-3 bg-white rounded-xl shadow-md">
                    <!-- Same QR Code (or different logic if needed) -->
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=TutorHubFinalPayment"
                         alt="Payment QR Code"
                         class="w-40 h-40 object-contain mix-blend-multiply">
                </div>
                <p class="text-xs text-center text-[var(--muted-foreground)] max-w-[200px]">
                    Supported: Venmo, CashApp, Bank Transfer
                </p>
            </div>

            <!-- Confirm Form -->
            <form :action="'/end/' + currentPayment.id" method="POST">
                @csrf
                @method('PATCH')

                <!-- Logic: Set status to 'done' to indicate full payment complete -->
                <input type="hidden" name="status" value="done">

                <button type="submit" class="w-full inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-bold h-11 px-6 bg-blue-900 text-white hover:bg-blue-950 transition-colors shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    Confirm Final Payment
                </button>
            </form>

            <div class="mt-4 text-center">
                 <button @click="finalPaymentModalOpen = false" class="text-sm text-[var(--muted-foreground)] hover:underline">Cancel</button>
            </div>
        </div>
    </div>
</div>


        <!-- "Edit Profile" MODAL -->
        <div x-show="userEditOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-start justify-center p-4 sm:p-6 md:p-10"
             style="display: none;">
            <div @click="userEditOpen = false" class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>
            <div x-show="userEditOpen"
                 @click.stop
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="relative w-full max-w-lg max-h-[90vh] overflow-y-auto bg-[var(--muted)] rounded-2xl shadow-xl">
                 <button @click="userEditOpen = false" class="absolute top-4 right-4 text-[var(--muted-foreground)] hover:text-[var(--foreground)] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
                <div class="p-8">
                    <div class="mb-8">
                        <h1 class="text-2xl font-bold tracking-tight mb-2">Edit Your Profile</h1>
                        <p class="text-[var(--muted-foreground)] text-sm">Update your personal information.</p>
                    </div>
                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="rounded-xl border border-[var(--border)]/50 bg-[var(--background)] shadow">
                             <div class="p-6 space-y-6">
                                <div>
                                    <label for="edit-name" class="text-sm font-medium leading-none block mb-2">Full Name</label>
                                    <input id="edit-name" name="name" type="text" value="{{ old('name', $user->name) }}" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2" />
                                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="edit-email" class="text-sm font-medium leading-none block mb-2">Email Address</label>
                                    <input id="edit-email" name="email" type="email" value="{{ $user->email }}" disabled class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm" />
                                </div>
                            </div>
                        </div>
                         <div class="rounded-xl border border-[var(--border)]/50 bg-[var(--background)] shadow">
                            <div class="p-6 space-y-6">
                                <div>
                                    <label for="password" class="text-sm font-medium leading-none block mb-2">New Password</label>
                                    <input id="password" name="password" type="password" placeholder="Leave blank to keep current password" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2" />
                                     @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="password_confirmation" class="text-sm font-medium leading-none block mb-2">Confirm New Password</label>
                                    <input id="password_confirmation" name="password_confirmation" type="password" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2" />
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end gap-4 pt-2">
                            <button type="button" @click="userEditOpen = false" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium border border-[var(--border)] h-10 px-4 py-2 bg-transparent hover:bg-[var(--background)] transition-colors">
                                Cancel
                            </button>
                            <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium h-10 px-4 py-2 bg-[var(--primary)] text-[var(--primary-foreground)] hover:opacity-90 transition-opacity">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- "Become a Tutor" MODAL -->
        @if(!$tutorProfile)
        <div x-show="tutorFormOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-start justify-center p-4 sm:p-6 md:p-10"
             style="display: none;">
            <div @click="tutorFormOpen = false" class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>
            <div x-show="tutorFormOpen"
                 @click.stop
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="relative w-full max-w-4xl max-h-[90vh] overflow-y-auto bg-[var(--muted)] rounded-2xl shadow-xl">
                <button @click="tutorFormOpen = false" class="absolute top-4 right-4 text-[var(--muted-foreground)] hover:text-[var(--foreground)] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
                <div class="p-8">
                     <div class="mb-8">
                         <h1 class="text-2xl font-bold tracking-tight mb-2">Become a Tutor</h1>
                         <p class="text-[var(--muted-foreground)] text-sm">
                             Share your knowledge and help students achieve their learning goals.
                         </p>
                     </div>
                    <form action="{{ route('tutor-profile.store') }}" method="POST" class="space-y-8">
                        @csrf
                        <div class="rounded-xl border border-[var(--border)]/50 bg-[var(--background)] shadow">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <h3 class="font-semibold tracking-tight text-lg flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-[var(--muted-foreground)]"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
                                    Basic Information
                                </h3>
                                <p class="text-sm text-[var(--muted-foreground)]">Tell us about yourself and your teaching background.</p>
                            </div>
                            <div class="p-6 pt-0 space-y-6">
                                <div>
                                    <label for="create-tutor-name" class="text-sm font-medium leading-none block mb-2">Tutor Display Name</label>
                                    <input id="create-tutor-name" name="name" value="{{ old('name', $user->name) }}" placeholder="e.g., Prof. Jane Doe" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2" required />
                                </div>
                                <div>
                                    <label for="create-tutor-bio" class="text-sm font-medium leading-none block mb-2">Bio</label>
                                    <textarea id="create-tutor-bio" name="bio" placeholder="Tell students about yourself..." class="flex min-h-[120px] w-full rounded-md border input-field px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2" required>{{ old('bio') }}</textarea>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="create-tutor-education" class="text-sm font-medium leading-none block mb-2">Education</label>
                                        <input id="create-tutor-education" name="education" value="{{ old('education') }}" placeholder="e.g., Bachelor's in Mathematics" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm" required />
                                    </div>
                                    <div>
                                        <label for="create-tutor-experience" class="text-sm font-medium leading-none block mb-2">Teaching Experience</label>
                                        <input id="create-tutor-experience" name="teaching_experience" value="{{ old('teaching_experience') }}" placeholder="e.g., 3 years" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm" required />
                                    </div>
                                </div>
                                <div>
                                    <label for="create-tutor-hourly-rate" class="text-sm font-medium leading-none block mb-2">Hourly Rate ($)</label>
                                    <input id="create-tutor-hourly-rate" name="hourly_rate" type="number" value="{{ old('hourly_rate') }}" min="1" step="1" placeholder="25" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm" required />
                                </div>
                            </div>
                        </div>

                        <div class="rounded-xl border border-[var(--border)]/50 bg-[var(--background)] shadow">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <h3 class="font-semibold tracking-tight text-lg">Subjects You Teach</h3>
                                <p class="text-sm text-[var(--muted-foreground)]">Select all subjects you're qualified to teach</p>
                            </div>
                            <div class="p-6 pt-0">
                                <div class="space-y-6">
                                    {{-- 1. Loop over $categories, not $subjects --}}
                                    @foreach ($categories as $category)
                                        <div>
                                            {{-- 2. This now works perfectly --}}
                                            <h3 class="font-semibold mb-3">{{ $category->category_name }}</h3>
                                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">

                                                {{-- 3. Loop over the subjects *from* that category --}}
                                                @foreach($category->subjects as $subject)
                                                    <div>
                                                        <label class="cursor-pointer">
                                                            <input type="checkbox" name="subjects[]" value="{{ $subject->id }}" class="hidden peer" {{ in_array($subject->id, old('subjects', [])) ? 'checked' : '' }}>

                                                            {{-- 4. Print the subject's name --}}
                                                            <span class="block text-center p-3 border border-[var(--border)] rounded-lg transition-colors hover:bg-[var(--muted)] peer-checked:bg-[var(--primary)] peer-checked:text-[var(--primary-foreground)] peer-checked:border-[var(--primary)]">{{ $subject->name }}</span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="rounded-xl border border-[var(--border)]/50 bg-[var(--background)] shadow">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <h3 class="font-semibold tracking-tight text-lg flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-[var(--muted-foreground)]"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                    Availability
                                </h3>
                                <p class="text-sm text-[var(--muted-foreground)]">Set your weekly availability</p>
                            </div>
                            <div class="p-6 pt-0">
                                <div class="space-y-4">
                                    @php $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']; @endphp
                                    @foreach($days as $index => $day)
                                    <div class="flex flex-wrap items-center gap-4">
                                        <div class="flex items-center space-x-2">
                                            <input type="checkbox" id="create-day-{{ $index }}" name="availability[{{$index}}][enabled]" class="h-4 w-4 rounded border-gray-300 text-[var(--primary)] focus:ring-[var(--primary)]" />
                                            <label for="create-day-{{ $index }}" class="w-20 text-sm font-medium">{{ $day }}</label>
                                            <input type="hidden" name="availability[{{$index}}][day_of_week]" value="{{ $day }}">
                                        </div>
                                        <div class="flex items-center gap-2 flex-1 min-w-[200px]">
                                            <input type="time" name="availability[{{$index}}][start_time]" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm" />
                                            <span class="text-[var(--muted-foreground)]">to</span>
                                            <input type="time" name="availability[{{$index}}][end_time]" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm" />
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 pt-4">
                            <button type="button" @click="tutorFormOpen = false" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium border border-[var(--border)] h-10 px-4 py-2 bg-transparent hover:bg-[var(--background)] transition-colors">
                                Cancel
                            </button>
                            <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium h-10 px-4 py-2 bg-[var(--primary)] text-[var(--primary-foreground)] hover:opacity-90 transition-opacity">
                                Create Tutor Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif

        <!-- "Edit Tutor Profile" MODAL -->
        @if($tutorProfile)
        @php
            // Prepare availability data for easy access in the form
            $availabilitiesByDay = $tutorProfile->availabilities->keyBy('day_of_week');
        @endphp
        <div x-show="tutorEditOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-start justify-center p-4 sm:p-6 md:p-10"
             style="display: none;">
            <div @click="tutorEditOpen = false" class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>
            <div x-show="tutorEditOpen"
                 @click.stop
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="relative w-full max-w-4xl max-h-[90vh] overflow-y-auto bg-[var(--muted)] rounded-2xl shadow-xl">
                <button @click="tutorEditOpen = false" class="absolute top-4 right-4 text-[var(--muted-foreground)] hover:text-[var(--foreground)] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
                <div class="p-8">
                     <div class="mb-8">
                         <h1 class="text-2xl font-bold tracking-tight mb-2">Edit Tutor Profile</h1>
                         <p class="text-[var(--muted-foreground)] text-sm">Update your teaching profile, subjects, and availability.</p>
                     </div>
                    <form action="{{ route('tutor-profile.update') }}" method="POST" class="space-y-8">
                        @csrf
                        <div class="rounded-xl border border-[var(--border)]/50 bg-[var(--background)] shadow">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <h3 class="font-semibold tracking-tight text-lg flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-[var(--muted-foreground)]"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
                                    Basic Information
                                </h3>
                            </div>
                            <div class="p-6 pt-0 space-y-6">
                                <div>
                                    <label for="edit-tutor-name" class="text-sm font-medium leading-none block mb-2">Tutor Display Name</label>
                                    <input id="edit-tutor-name" name="name" value="{{ old('name', $tutorProfile->name) }}" placeholder="e.g., Prof. Jane Doe" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2" required />
                                </div>
                                <div>
                                    <label for="edit-tutor-bio" class="text-sm font-medium leading-none block mb-2">Bio</label>
                                    <textarea id="edit-tutor-bio" name="bio" class="flex min-h-[120px] w-full rounded-md border input-field px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2" required>{{ old('bio', $tutorProfile->bio) }}</textarea>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="edit-tutor-education" class="text-sm font-medium leading-none block mb-2">Education</label>
                                        <input id="edit-tutor-education" name="education" value="{{ old('education', $tutorProfile->education) }}" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm" required />
                                    </div>
                                    <div>
                                        <label for="edit-tutor-experience" class="text-sm font-medium leading-none block mb-2">Teaching Experience</label>
                                        <input id="edit-tutor-experience" name="teaching_experience" value="{{ old('teaching_experience', $tutorProfile->teaching_experience) }}" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm" required />
                                    </div>
                                </div>
                                <div>
                                    <label for="edit-tutor-hourly-rate" class="text-sm font-medium leading-none block mb-2">Hourly Rate ($)</label>
                                    <input id="edit-tutor-hourly-rate" name="hourly_rate" type="number" min="1" step="1" value="{{ old('hourly_rate', $tutorProfile->hourly_rate) }}" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm" required />
                                </div>
                            </div>
                        </div>

                        <div class="rounded-xl border border-[var(--border)]/50 bg-[var(--background)] shadow">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <h3 class="font-semibold tracking-tight text-lg">Your Subjects</h3>
                            </div>
                            <div class="p-6 pt-0">
                                <div class="space-y-6">
                                    @foreach ($categories as $category)
                                        <div>
                                            {{-- 2. This now works perfectly --}}
                                            <h3 class="font-semibold mb-3">{{ $category->category_name }}</h3>
                                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">

                                                {{-- 3. Loop over the subjects *from* that category --}}
                                                @foreach($category->subjects as $subject)
                                                    <div>
                                                        <label class="cursor-pointer">
                                                            <input type="checkbox" name="subjects[]" value="{{ $subject->id }}" class="hidden peer" {{ in_array($subject->id, $subjects) ? 'checked' : '' }}>

                                                            {{-- 4. Print the subject's name --}}
                                                            <span class="block text-center p-3 border border-[var(--border)] rounded-lg transition-colors hover:bg-[var(--muted)] peer-checked:bg-[var(--primary)] peer-checked:text-[var(--primary-foreground)] peer-checked:border-[var(--primary)]">{{ $subject->name }}</span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                         <div class="rounded-xl border border-[var(--border)]/50 bg-[var(--background)] shadow">
                            <div class="flex flex-col space-y-1.5 p-6">
                                <h3 class="font-semibold tracking-tight text-lg flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-[var(--muted-foreground)]"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                    Availability
                                </h3>
                                <p class="text-sm text-[var(--muted-foreground)]">Update your weekly availability.</p>
                            </div>
                            <div class="p-6 pt-0">
                                <div class="space-y-4">
                                    @php $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']; @endphp
                                    @foreach($days as $index => $day)
                                    @php $availability = $availabilitiesByDay->get($day); @endphp
                                    <div class="flex flex-wrap items-center gap-4">
                                        <div class="flex items-center space-x-2">
                                            <input type="checkbox" id="edit-day-{{ $index }}" name="availability[{{$index}}][enabled]" class="h-4 w-4 rounded border-gray-300 text-[var(--primary)] focus:ring-[var(--primary)]" {{ $availability ? 'checked' : '' }} />
                                            <label for="edit-day-{{ $index }}" class="w-20 text-sm font-medium">{{ $day }}</label>
                                            <input type="hidden" name="availability[{{$index}}][day_of_week]" value="{{ $day }}">
                                        </div>
                                        <div class="flex items-center gap-2 flex-1 min-w-[200px]">
                                            <input type="time" name="availability[{{$index}}][start_time]" value="{{ $availability ? \Carbon\Carbon::parse($availability->start_time)->format('H:i') : '' }}" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm" />
                                            <span class="text-[var(--muted-foreground)]">to</span>
                                            <input type="time" name="availability[{{$index}}][end_time]" value="{{ $availability ? \Carbon\Carbon::parse($availability->end_time)->format('H:i') : '' }}" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm" />
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 pt-4">
                            <button type="button" @click="tutorEditOpen = false" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium border border-[var(--border)] h-10 px-4 py-2 bg-transparent hover:bg-[var(--background)] transition-colors">
                                Cancel
                            </button>
                            <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium h-10 px-4 py-2 bg-[var(--primary)] text-[var(--primary-foreground)] hover:opacity-90 transition-opacity">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif

    </div>

    <!-- "Leave a Review" MODAL -->
<!-- Only render this HTML if there is actually a session to rate -->
@if(isset($pendingRatingSession) && $pendingRatingSession)
<div x-show="ratingModalOpen"
     x-transition:enter="ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 md:p-10"
     style="display: none;">

    <!-- Backdrop (Prevent closing to force rating? Optional. currently allows click outside) -->
    <div @click="ratingModalOpen = false" class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>

    <!-- Modal Content -->
    <div x-show="ratingModalOpen"
         @click.stop
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="relative w-full max-w-lg bg-[var(--muted)] rounded-2xl shadow-xl overflow-hidden border border-[var(--border)]">

        <div class="p-8 text-center">
            <!-- Illustration/Icon -->
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-yellow-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-600"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
            </div>

            <h1 class="text-2xl font-bold tracking-tight mb-2">How was your session?</h1>
            <p class="text-[var(--muted-foreground)] text-sm mb-6">
                Please rate your experience with <span class="font-semibold text-[var(--foreground)]">{{ $pendingRatingSession->tutor->name ?? 'Tutor' }}</span> on {{ $pendingRatingSession->created_at }}.
            </p>

            <form action="{{ route('ratings.store') }}" method="POST" class="space-y-6 text-left">
                @csrf
                @method('patch')
                <!-- Hidden IDs -->
                <input type="hidden" name="reservation_id" value="{{ $pendingRatingSession->id }}">
                <input type="hidden" name="tutor_profile_id" value="{{ $pendingRatingSession->tutor_profile_id }}">

                <!-- Interactive Star Rating -->
                <div class="flex flex-col items-center justify-center space-y-2">
                    <div class="flex items-center space-x-1" @mouseleave="ratingHover = 0">
                        @foreach(range(1, 5) as $star)
                            <button type="button"
                                    @mouseenter="ratingHover = {{ $star }}"
                                    @click="ratingScore = {{ $star }}"
                                    class="focus:outline-none transition-transform hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                     :fill="(ratingHover >= {{ $star }} || ratingScore >= {{ $star }}) ? 'currentColor' : 'none'"
                                     :class="(ratingHover >= {{ $star }} || ratingScore >= {{ $star }}) ? 'text-yellow-400' : 'text-gray-300'"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            </button>
                        @endforeach
                    </div>
                    <!-- Hidden Input that actually sends the data -->
                    <input type="hidden" name="rating" :value="ratingScore" required>
                    <p class="text-xs font-medium text-[var(--primary)] h-4" x-text="['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'][ratingHover || ratingScore]"></p>
                </div>

                <!-- Review Textarea -->
                <div>
                    <label for="review" class="text-sm font-medium leading-none block mb-2">Write a review (optional)</label>
                    <textarea id="review" name="review" placeholder="What did you learn? Was the tutor helpful?"
                              class="flex min-h-[100px] w-full rounded-md border input-field px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2"></textarea>
                </div>

                <div class="flex gap-3">
                    <!-- Skip Button (Optional logic needed in backend if you allow skipping) -->
                    {{-- <button type="button" @click="ratingModalOpen = false" class="flex-1 inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium border border-[var(--border)] h-10 px-4 py-2 bg-transparent hover:bg-[var(--background)] transition-colors">
                        Skip
                    </button> --}}

                    <!-- Submit Button -->
                    <button type="submit"
                            :disabled="ratingScore === 0"
                            :class="ratingScore === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:opacity-90'"
                            class="flex-1 inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium h-10 px-4 py-2 bg-[var(--primary)] text-[var(--primary-foreground)] transition-opacity">
                        Submit Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- "Reject Session" MODAL -->
<div x-show="rejectModalOpen"
     x-transition:enter="ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 flex items-start justify-center p-4 sm:p-6 md:p-10"
     style="display: none;">

    <!-- Backdrop -->
    <div @click="rejectModalOpen = false" class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>

    <!-- Modal Content -->
    <div x-show="rejectModalOpen"
         @click.stop
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="relative w-full max-w-md bg-[var(--muted)] rounded-2xl shadow-xl overflow-hidden border border-[var(--border)]">

        <!-- Close Button -->
        <button @click="rejectModalOpen = false" class="absolute top-4 right-4 text-[var(--muted-foreground)] hover:text-[var(--foreground)] transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>

        <div class="p-8">
            <div class="mb-6 text-center">
                <!-- Warning Icon -->
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-red-100 border border-red-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-600"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                </div>

                <h1 class="text-2xl font-bold tracking-tight mb-2">Reject Session</h1>
                <p class="text-[var(--muted-foreground)] text-sm">
                    Are you sure you want to reject the session with <span class="font-semibold text-[var(--foreground)]" x-text="currentRejection.name"></span>?
                </p>
            </div>

            <!-- Rejection Form -->
            <form :action="'/reject/' + currentRejection.id" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <div>
                    <label for="rejection_reason" class="text-xs text-[var(--muted-foreground)] uppercase tracking-wide font-semibold block mb-2">Reason for Rejection</label>
                    <textarea id="rejection_reason"
                              name="reason"
                              required
                              placeholder="Please briefly explain why (e.g., Schedule conflict)..."
                              class="flex min-h-[100px] w-full rounded-md border input-field px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 placeholder:text-[var(--muted-foreground)]/50"></textarea>
                </div>

                <div class="flex flex-col-reverse sm:flex-row gap-3">
                    <button type="button" @click="rejectModalOpen = false" class="flex-1 inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium border border-[var(--border)] h-10 px-4 py-2 bg-transparent hover:bg-[var(--background)] transition-colors">
                        Cancel
                    </button>

                    <button type="submit" class="flex-1 inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium h-10 px-4 py-2 bg-red-600 text-white hover:bg-red-700 transition-colors shadow-sm">
                        Confirm Rejection
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>

