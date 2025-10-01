<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TutorHub - Landing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* * =================================================================
         * CUSTOMIZED COLOR PALETTE
         * =================================================================
         * Colors derived from the provided image.
         */
        :root {
            --background: #EEEBE4; /* Off-white/Cream */
            --foreground: #212C68; /* Dark Blue */
            --primary: #B83A42; /* Red */
            --primary-foreground: #ffffff; /* White */
            --primary-light: rgba(184, 58, 66, 0.1);
            --muted: #e6e3dd; /* Slightly darker cream */
            --muted-foreground: #35477C; /* Medium Blue */
            --border: #698196; /* Desaturated Blue/Grey */
        }

        /* Smooth transitions for any potential future interactions */
        * {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }
    </style>
</head>
<body class="bg-[var(--background)] text-[var(--foreground)]">

@php
$features = [
    [
      'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-[var(--primary)]"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
      'title' => "Find Expert Tutors",
      'description' => "Browse through verified tutors across 25+ subjects with detailed profiles and reviews."
    ],
    [
      'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-[var(--primary)]"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>',
      'title' => "Flexible Scheduling",
      'description' => "Book sessions that fit your schedule with instant confirmation and calendar integration."
    ],
    [
      'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-[var(--primary)]"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>',
      'title' => "Transparent Pricing",
      'description' => "See hourly rates upfront with no hidden fees. Pay only for confirmed sessions."
    ],
    [
      'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-[var(--primary)]"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>',
      'title' => "Quality Guaranteed",
      'description' => "All tutors are verified with student reviews and ratings to ensure quality learning."
    ]
];
$subjects = ["Mathematics", "Physics", "Chemistry", "Biology", "English", "Spanish", "Programming", "SAT Prep", "Calculus", "Statistics", "Economics", "Accounting"];
$stats = [
    ['number' => "500+", 'label' => "Expert Tutors"],
    ['number' => "10,000+", 'label' => "Sessions Completed"],
    ['number' => "4.9", 'label' => "Average Rating"],
    ['number' => "25+", 'label' => "Subjects Available"]
];
$isAuthenticated = false; // Set to true or false to see conditional rendering
@endphp

<div class="min-h-screen">
    <nav class="border-b border-[var(--border)]/50 bg-[var(--background)]/95 backdrop-blur sticky top-0 z-50">
        <div class="container mx-auto px-4 h-16 flex items-center justify-between max-w-6xl">
            <a href="/" class="flex items-center gap-2 cursor-pointer">
                <img src="{{ asset("logo_tutorhub.png") }}" alt="TutorHub Logo" class="w-8 h-8 rounded-md" />
                <span class="text-xl font-bold tracking-tight text-[var(--foreground)]">TutorHub</span>
            </a>
            <div class="flex items-center gap-4">
                @if($isAuthenticated)
                    <a href="/dashboard" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium h-10 px-4 py-2 bg-[var(--primary)] text-[var(--primary-foreground)] hover:opacity-90">
                        Dashboard
                    </a>
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium border border-[var(--border)] h-10 px-4 py-2 bg-transparent hover:bg-[var(--muted)]">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="/auth" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium h-10 px-4 py-2 hover:bg-[var(--muted)]">
                        Login
                    </a>
                    <a href="/auth" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium h-10 px-4 py-2 bg-[var(--primary)] text-[var(--primary-foreground)] hover:opacity-90">
                        Get Started
                    </a>
                @endif
            </div>
        </div>
    </nav>

    <main>
        <section class="py-24 px-4">
            <div class="container mx-auto max-w-6xl">
                <div class="text-center space-y-8">
                    <div class="space-y-4">
                        <h1 class="text-5xl md:text-6xl font-bold tracking-tight">
                            Learn from the
                            <span class="text-[var(--primary)]"> Best Tutors</span>
                        </h1>
                        <p class="text-xl text-[var(--muted-foreground)] max-w-2xl mx-auto leading-relaxed">
                            Connect with expert tutors for personalized learning sessions.
                            Book by the hour, learn at your pace, achieve your goals.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ $isAuthenticated ? '/browse' : '/auth' }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-lg font-medium h-auto px-8 py-6 bg-[var(--primary)] text-[var(--primary-foreground)] hover:opacity-90">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                            Find a Tutor
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 ml-2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                        </a>
                        <a href="{{ $isAuthenticated ? '/become-tutor' : '/auth' }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-lg font-medium border border-[var(--border)] h-auto px-8 py-6 bg-transparent hover:bg-[var(--muted)]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
                            Become a Tutor
                        </a>
                    </div>

                    <div class="pt-8">
                        <p class="text-sm text-[var(--muted-foreground)] mb-4">Popular subjects:</p>
                        <div class="flex flex-wrap justify-center gap-2 max-w-3xl mx-auto">
                            @foreach(array_slice($subjects, 0, 8) as $subject)
                                <a href="/browse?subject={{ urlencode($subject) }}" class="inline-flex items-center rounded-full border border-[var(--border)]/50 px-3 py-1 text-sm font-semibold transition-colors focus:outline-none focus:ring-2 bg-[var(--muted)] text-[var(--muted-foreground)] hover:bg-[var(--border)]/40 cursor-pointer">
                                    {{ $subject }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 px-4 bg-[var(--muted)]">
            <div class="container mx-auto max-w-6xl">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    @foreach($stats as $stat)
                        <div class="text-center">
                            <div class="text-3xl md:text-4xl font-bold text-[var(--primary)] mb-2">
                                {{ $stat['number'] }}
                            </div>
                            <div class="text-[var(--muted-foreground)]">{{ $stat['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="py-24 px-4">
            <div class="container mx-auto max-w-6xl">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold tracking-tight mb-4">
                        Why Choose TutorHub?
                    </h2>
                    <p class="text-xl text-[var(--muted-foreground)] max-w-2xl mx-auto">
                        We make learning accessible, flexible, and effective for everyone
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($features as $feature)
                        <div class="rounded-lg h-full text-center">
                            <div class="p-6">
                                <div class="w-12 h-12 mx-auto mb-4 bg-[var(--primary-light)] rounded-lg flex items-center justify-center">
                                    {!! $feature['icon'] !!}
                                </div>
                                <h3 class="text-lg font-semibold">{{ $feature['title'] }}</h3>
                            </div>
                            <div class="p-6 pt-0">
                                <p class="text-base leading-relaxed text-[var(--muted-foreground)]">
                                    {{ $feature['description'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="py-24 px-4 bg-[var(--muted)]">
            <div class="container mx-auto max-w-6xl">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold tracking-tight mb-4">
                        How It Works
                    </h2>
                    <p class="text-xl text-[var(--muted-foreground)]">
                        Get started in just three simple steps
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @php
                    $steps = [
                        ['step' => "1", 'title' => "Browse & Choose", 'description' => "Search through our verified tutors, read reviews, and find the perfect match for your learning needs."],
                        ['step' => "2", 'title' => "Book a Session", 'description' => "Schedule a session at your convenience. Choose the date, time, and duration that works for you."],
                        ['step' => "3", 'title' => "Start Learning", 'description' => "Join your session and start learning. Rate your experience and book follow-up sessions."]
                    ];
                    @endphp
                    @foreach($steps as $item)
                        <div class="text-center">
                            <div class="w-16 h-16 mx-auto mb-6 bg-[var(--primary)] text-[var(--primary-foreground)] rounded-full flex items-center justify-center text-2xl font-bold">
                                {{ $item['step'] }}
                            </div>
                            <h3 class="text-xl font-semibold mb-4">{{ $item['title'] }}</h3>
                            <p class="text-[var(--muted-foreground)] leading-relaxed">
                                {{ $item['description'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="py-24 px-4">
            <div class="container mx-auto max-w-4xl">
                <div class="rounded-lg text-center p-12 bg-[var(--primary)] text-[var(--primary-foreground)]">
                    <div class="p-6 pb-8">
                        <h2 class="text-3xl md:text-4xl font-bold mb-4">
                            Ready to Start Learning?
                        </h2>
                        <p class="text-xl opacity-80 max-w-2xl mx-auto">
                            Join thousands of students who are already achieving their goals with personalized tutoring
                        </p>
                    </div>
                    <div class="p-6 pt-0">
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ $isAuthenticated ? '/browse' : '/auth' }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-lg font-medium h-auto px-8 py-6 bg-[var(--background)] text-[var(--foreground)] hover:opacity-90">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                Find Your Tutor
                            </a>
                            <a href="{{ $isAuthenticated ? '/become-tutor' : '/auth' }}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-lg font-medium h-auto px-8 py-6 bg-transparent border border-white/20 hover:bg-white/10">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 mr-2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
                                Teach & Earn
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="border-t border-[var(--border)]/50 py-12 px-4">
        <div class="container mx-auto max-w-6xl">
            <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                <div class="flex items-center gap-2">
                     <img src="https://placehold.co/32x32/B83A42/FFFFFF?text=T" alt="TutorHub Logo" class="w-8 h-8 rounded-md" />
                    <span class="text-xl font-bold tracking-tight text-[var(--foreground)]">TutorHub</span>
                </div>
                <div class="flex items-center gap-6 text-sm text-[var(--muted-foreground)]">
                    <span>© {{ date('Y') }} TutorHub. All rights reserved.</span>
                    <span>•</span>
                    <a href="#" class="hover:text-[var(--foreground)] transition-colors">Privacy</a>
                    <span>•</span>
                    <a href="#" class="hover:text-[var(--foreground)] transition-colors">Terms</a>
                </div>
            </div>
        </div>
    </footer>
</div>

</body>
</html>

