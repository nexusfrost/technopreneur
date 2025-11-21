<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Tutors</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* * =================================================================
         * CUSTOMIZED COLOR PALETTE
         * =================================================================
         */
        :root {
            --background: #F0EBE2; /* Off-white/Cream */
            --foreground: #1A2A57; /* Dark Blue */
            --primary: #B83A3F; /* Red */
            --primary-foreground: #ffffff; /* White */
            --muted: #e6e3dd; /* Slightly darker cream for body bg */
            --muted-foreground: #2E4980; /* Medium Blue */
            --border: #6A8094; /* Desaturated Blue/Grey */
        }

        /* Applying custom colors to base elements */
        body {
            background-color: var(--muted);
            color: var(--foreground);
        }
        .card {
            background-color: var(--background);
            border-color: var(--border);
        }
        .input-field {
            border-color: var(--border);
            background-color: transparent;
        }
        .input-field:focus {
            --tw-ring-color: var(--primary);
        }
    </style>
</head>
<body class="bg-[var(--muted)] text-[var(--foreground)]">

<div class="min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <div class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight mb-2">
                Find Your Perfect Tutor
            </h1>
            <p class="text-[var(--muted-foreground)]">
                Browse through our verified tutors and book your next learning session
            </p>
        </div>

        <div>
            <div class="flex items-center justify-between mb-4">
                <div class="text-sm text-[var(--muted-foreground)]">
                    Showing lecturers for: Calculus
                </div>
                {{-- <a href="/browse" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium border border-[var(--border)] h-9 px-3 bg-transparent hover:bg-[var(--background)] transition-colors">
                    All Majors
                </a> --}}
            </div>

            <div class="rounded-xl border card shadow mb-8">
                <div class="flex flex-col space-y-1.5 p-6">
                    <h3 class="font-semibold tracking-tight text-lg flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-[var(--muted-foreground)]"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                        Filter Tutors
                    </h3>
                </div>
                <form class="p-6 pt-0" action="{{ route('search-tutors') }}" method="get">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-3 h-4 w-4 text-[var(--muted-foreground)]/80"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input name="search" placeholder="Search tutors..." class="flex h-10 w-full rounded-md border input-field bg-transparent px-3 py-2 text-sm pl-9 focus:outline-none focus:ring-2 focus:ring-offset-2" />
                        </div>

                        <select name="subject" class="flex h-10 items-center justify-between rounded-md border input-field bg-transparent px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2">
                            <option value="0">All Subjects</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>

                        <input type="number" name="min_rate" placeholder="Min rate ($)" class="flex h-10 w-full rounded-md border input-field bg-transparent px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2" />
                        <input type="number" name="max_rate" placeholder="Max rate ($)" class="flex h-10 w-full rounded-md border input-field bg-transparent px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2" />

                    </div>
                        <button type="submit" class="mt-6 inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium h-9 px-3 w-full bg-[var(--primary)] text-[var(--primary-foreground)] hover:opacity-90 transition-opacity">
                                    Search!
                                </button>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach ($tutors as $tutor)
                    <a href="{{ route('view-tutor', ['tutorProfile' => $tutor->id]) }}" class="flex flex-col rounded-xl border card shadow h-full hover:shadow-lg transition-shadow cursor-pointer">
                    <div class="flex flex-col space-y-1.5 p-6 pb-4">
                        <div class="flex items-center gap-3">
                            <span class="relative flex h-12 w-12 shrink-0 overflow-hidden rounded-full">
                                <img class="aspect-square h-full w-full" src="https://i.pravatar.cc/150?img=1" />
                            </span>
                            <div class="flex-1">
                                <h3 class="font-semibold tracking-tight text-lg">{{ $tutor->name }}</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <div class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-yellow-400 fill-yellow-400"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                        <span class="text-sm font-medium">{{ $tutor->rating }}</span>
                                    </div>
                                    <span class="text-sm text-[var(--muted-foreground)]">({{ 1 }} reviews)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="p-6 pt-0 flex flex-col flex-grow space-y-4">
                            <p class="text-sm text-[var(--muted-foreground)] line-clamp-3">{{ $tutor->bio }}</p>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium">Hourly Rate</span>
                                    <div class="flex items-center gap-1 text-lg font-bold text-[var(--primary)]">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                        {{ $tutor->hourly_rate }}
                                    </div>
                                </div>
                                <div>
                                    <span class="text-sm font-medium mb-2 block">Subjects</span>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($tutor->subjects as $subject)
                                            <div class="inline-flex items-center rounded-full border border-[var(--border)]/50 px-2.5 py-0.5 text-xs font-semibold bg-[var(--muted)] text-[var(--muted-foreground)]">{{ $subject->name }}</div>

                                        @endforeach
                                        {{-- <div class="inline-flex items-center rounded-full border border-[var(--border)]/50 px-2.5 py-0.5 text-xs font-semibold bg-[var(--muted)] text-[var(--muted-foreground)]">Calculus</div>
                                        <div class="inline-flex items-center rounded-full border border-[var(--border)]/50 px-2.5 py-0.5 text-xs font-semibold bg-[var(--muted)] text-[var(--muted-foreground)]">Statistics</div>
                                        <div class="inline-flex items-center rounded-full border border-[var(--border)]/50 px-2.5 py-0.5 text-xs font-semibold bg-[var(--muted)] text-[var(--muted-foreground)]">Algebra</div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class=" flex flex-grow">
                                <button class="mt-auto inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium h-9 px-3 w-full bg-[var(--primary)] text-[var(--primary-foreground)] hover:opacity-90 transition-opacity">
                                    View Profile
                                </button>
                            </div>
                        </div>
                    </a>
                @endforeach

                <div class="mt-8 flex min-w-max">
                    {{ $tutors->links() }}
                </div>

                <!-- Tutor Card 1: John Doe -->
                {{-- <a href="/tutor/101" class="flex flex-col rounded-xl border card shadow h-full hover:shadow-lg transition-shadow cursor-pointer">
                    <div class="flex flex-col space-y-1.5 p-6 pb-4">
                        <div class="flex items-center gap-3">
                            <span class="relative flex h-12 w-12 shrink-0 overflow-hidden rounded-full">
                                <img class="aspect-square h-full w-full" src="https://i.pravatar.cc/150?img=1" />
                            </span>
                            <div class="flex-1">
                                <h3 class="font-semibold tracking-tight text-lg">John Doe</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <div class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-yellow-400 fill-yellow-400"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                        <span class="text-sm font-medium">4.9</span>
                                    </div>
                                    <span class="text-sm text-[var(--muted-foreground)]">(120 reviews)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="p-6 pt-0 flex flex-col flex-grow space-y-4">
                            <p class="text-sm text-[var(--muted-foreground)] line-clamp-3">Experienced mathematics professor with a passion for helping students succeed in calculus and statistics.</p>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium">Hourly Rate</span>
                                    <div class="flex items-center gap-1 text-lg font-bold text-[var(--primary)]">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                        50
                                    </div>
                                </div>
                                <div>
                                    <span class="text-sm font-medium mb-2 block">Subjects</span>
                                    <div class="flex flex-wrap gap-1">
                                        <div class="inline-flex items-center rounded-full border border-[var(--border)]/50 px-2.5 py-0.5 text-xs font-semibold bg-[var(--muted)] text-[var(--muted-foreground)]">Calculus</div>
                                        <div class="inline-flex items-center rounded-full border border-[var(--border)]/50 px-2.5 py-0.5 text-xs font-semibold bg-[var(--muted)] text-[var(--muted-foreground)]">Statistics</div>
                                        <div class="inline-flex items-center rounded-full border border-[var(--border)]/50 px-2.5 py-0.5 text-xs font-semibold bg-[var(--muted)] text-[var(--muted-foreground)]">Algebra</div>
                                    </div>
                                </div>
                            </div>
                            <div class=" flex flex-grow">
                                <button class="mt-auto inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium h-9 px-3 w-full bg-[var(--primary)] text-[var(--primary-foreground)] hover:opacity-90 transition-opacity">
                                    View Profile
                                </button>
                            </div>
                        </div>
                </a>
                <!-- Tutor Card 2: Jane Smith -->
                <a href="/tutor/102" class="flex flex-col rounded-xl border card shadow h-full hover:shadow-lg transition-shadow cursor-pointer">
                    <div class="flex flex-col space-y-1.5 p-6 pb-4">
                        <div class="flex items-center gap-3">
                            <span class="relative flex h-12 w-12 shrink-0 overflow-hidden rounded-full">
                                <img class="aspect-square h-full w-full" src="https://i.pravatar.cc/150?img=2" />
                            </span>
                            <div class="flex-1">
                                <h3 class="font-semibold tracking-tight text-lg">Jane Smith</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <div class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-yellow-400 fill-yellow-400"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                        <span class="text-sm font-medium">4.8</span>
                                    </div>
                                    <span class="text-sm text-[var(--muted-foreground)]">(85 reviews)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 pt-0 flex flex-col flex-grow space-y-4">
                        <p class="text-sm text-[var(--muted-foreground)] line-clamp-3">Full-stack developer with 10+ years of experience. I specialize in teaching modern web development with React and Node.js.</p>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium">Hourly Rate</span>
                                <div class="flex items-center gap-1 text-lg font-bold text-[var(--primary)]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                    65
                                </div>
                            </div>
                            <div>
                                <span class="text-sm font-medium mb-2 block">Subjects</span>
                                <div class="flex flex-wrap gap-1">
                                    <div class="inline-flex items-center rounded-full border border-[var(--border)]/50 px-2.5 py-0.5 text-xs font-semibold bg-[var(--muted)] text-[var(--muted-foreground)]">Web Development</div>
                                    <div class="inline-flex items-center rounded-full border border-[var(--border)]/50 px-2.5 py-0.5 text-xs font-semibold bg-[var(--muted)] text-[var(--muted-foreground)]">JavaScript</div>
                                    <div class="inline-flex items-center rounded-full border border-[var(--border)]/50 px-2.5 py-0.5 text-xs font-semibold bg-[var(--muted)] text-[var(--muted-foreground)]">React</div>
                                    <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold border-dashed text-[var(--muted-foreground)]">+1 more</div>
                                </div>
                            </div>
                        </div>
                        <div class=" flex flex-grow">
                            <button class="mt-auto inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium h-9 px-3 w-full bg-[var(--primary)] text-[var(--primary-foreground)] hover:opacity-90 transition-opacity">
                                View Profile
                            </button>
                        </div>
                    </div>
                </a>
                <!-- Tutor Card 3: Peter Jones -->
                <a href="/tutor/103" class="flex flex-col rounded-xl border card shadow h-full hover:shadow-lg transition-shadow cursor-pointer">
                    <div class="flex flex-col space-y-1.5 p-6 pb-4">
                        <div class="flex items-center gap-3">
                            <span class="relative flex h-12 w-12 shrink-0 overflow-hidden rounded-full">
                                <img class="aspect-square h-full w-full" src="https://i.pravatar.cc/150?img=3" />
                            </span>
                            <div class="flex-1">
                                <h3 class="font-semibold tracking-tight text-lg">Peter Jones</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-sm text-[var(--muted-foreground)]">New tutor</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 pt-0 space-y-4 flex flex-col flex-grow">
                        <p class="text-sm text-[var(--muted-foreground)] line-clamp-3">Recent chemistry graduate eager to help students understand complex chemical concepts.</p>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium">Hourly Rate</span>
                                <div class="flex items-center gap-1 text-lg font-bold text-[var(--primary)]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                    30
                                </div>
                            </div>
                            <div>
                                <span class="text-sm font-medium mb-2 block">Subjects</span>
                                <div class="flex flex-wrap gap-1">
                                    <div class="inline-flex items-center rounded-full border border-[var(--border)]/50 px-2.5 py-0.5 text-xs font-semibold bg-[var(--muted)] text-[var(--muted-foreground)]">Chemistry</div>
                                    <div class="inline-flex items-center rounded-full border border-[var(--border)]/50 px-2.5 py-0.5 text-xs font-semibold bg-[var(--muted)] text-[var(--muted-foreground)]">Organic Chemistry</div>
                                </div>
                            </div>
                        </div>
                        <div class=" flex flex-grow">
                            <button class="mt-auto inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium h-9 px-3 w-full bg-[var(--primary)] text-[var(--primary-foreground)] hover:opacity-90 transition-opacity">
                                View Profile
                            </button>
                        </div> --}}
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
