<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Become a Tutor</title>
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
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight mb-2">Become a Tutor</h1>
            <p class="text-[var(--muted-foreground)]">
                Share your knowledge and help students achieve their learning goals
            </p>
        </div>

        <form action="/tutor-profile" method="POST" class="space-y-8">
            <!-- CSRF token would be needed for a live Laravel form -->
            <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}" /> -->

            <div class="rounded-xl border card shadow bg-white">
                <div class="flex flex-col space-y-1.5 p-6">
                    <h3 class="font-semibold tracking-tight text-lg flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-[var(--muted-foreground)]"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
                        Basic Information
                    </h3>
                    <p class="text-sm text-[var(--muted-foreground)]">
                        Tell us about yourself and your teaching background
                    </p>
                </div>
                <div class="p-6 pt-0 space-y-6">
                    <div>
                        <label for="name" class="text-sm font-medium leading-none block mb-2">Full Name</label>
                        <input id="name" name="name" placeholder="e.g., Jane Doe" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2" />
                    </div>
                    <div>
                        <label for="bio" class="text-sm font-medium leading-none block mb-2">Bio</label>
                        <textarea id="bio" name="bio" placeholder="Tell students about yourself, your teaching style, and what makes you a great tutor..." class="flex min-h-[120px] w-full rounded-md border input-field px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2" required></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="education" class="text-sm font-medium leading-none block mb-2">Education</label>
                            <input id="education" name="education" placeholder="e.g., Bachelor's in Mathematics, MIT" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2" required />
                        </div>
                        <div>
                            <label for="experience" class="text-sm font-medium leading-none block mb-2">Teaching Experience</label>
                            <input id="experience" name="experience" placeholder="e.g., 3 years of private tutoring" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2" required />
                        </div>
                    </div>
                    <div>
                        <label for="hourlyRate" class="text-sm font-medium leading-none block mb-2">Hourly Rate ($)</label>
                        <input id="hourlyRate" name="hourlyRate" type="number" min="1" step="1" placeholder="25" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2" required />
                    </div>
                </div>
            </div>

            <div class="rounded-xl border card shadow bg-white">
                <div class="flex flex-col space-y-1.5 p-6">
                    <h3 class="font-semibold tracking-tight text-lg">Subjects You Teach</h3>
                    <p class="text-sm text-[var(--muted-foreground)]">
                        Select all subjects you're qualified to teach
                    </p>
                </div>
                <div class="p-6 pt-0">
                    <div class="space-y-6">
                        <div>
                            <h3 class="font-semibold mb-3">Mathematics</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                <div><label class="cursor-pointer"><input type="checkbox" name="subjects[]" value="Calculus" class="hidden peer"><span class="block text-center p-3 border border-[var(--border)] rounded-lg transition-colors hover:bg-[var(--muted)] peer-checked:bg-[var(--primary)] peer-checked:text-[var(--primary-foreground)] peer-checked:border-[var(--primary)]">Calculus</span></label></div>
                                <div><label class="cursor-pointer"><input type="checkbox" name="subjects[]" value="Statistics" class="hidden peer"><span class="block text-center p-3 border border-[var(--border)] rounded-lg transition-colors hover:bg-[var(--muted)] peer-checked:bg-[var(--primary)] peer-checked:text-[var(--primary-foreground)] peer-checked:border-[var(--primary)]">Statistics</span></label></div>
                                <div><label class="cursor-pointer"><input type="checkbox" name="subjects[]" value="Algebra" class="hidden peer"><span class="block text-center p-3 border border-[var(--border)] rounded-lg transition-colors hover:bg-[var(--muted)] peer-checked:bg-[var(--primary)] peer-checked:text-[var(--primary-foreground)] peer-checked:border-[var(--primary)]">Algebra</span></label></div>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-3">Science</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                <div><label class="cursor-pointer"><input type="checkbox" name="subjects[]" value="Physics" class="hidden peer"><span class="block text-center p-3 border border-[var(--border)] rounded-lg transition-colors hover:bg-[var(--muted)] peer-checked:bg-[var(--primary)] peer-checked:text-[var(--primary-foreground)] peer-checked:border-[var(--primary)]">Physics</span></label></div>
                                <div><label class="cursor-pointer"><input type="checkbox" name="subjects[]" value="Chemistry" class="hidden peer"><span class="block text-center p-3 border border-[var(--border)] rounded-lg transition-colors hover:bg-[var(--muted)] peer-checked:bg-[var(--primary)] peer-checked:text-[var(--primary-foreground)] peer-checked:border-[var(--primary)]">Chemistry</span></label></div>
                                <div><label class="cursor-pointer"><input type="checkbox" name="subjects[]" value="Biology" class="hidden peer"><span class="block text-center p-3 border border-[var(--border)] rounded-lg transition-colors hover:bg-[var(--muted)] peer-checked:bg-[var(--primary)] peer-checked:text-[var(--primary-foreground)] peer-checked:border-[var(--primary)]">Biology</span></label></div>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-3">Technology</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                <div><label class="cursor-pointer"><input type="checkbox" name="subjects[]" value="Web Development" class="hidden peer"><span class="block text-center p-3 border border-[var(--border)] rounded-lg transition-colors hover:bg-[var(--muted)] peer-checked:bg-[var(--primary)] peer-checked:text-[var(--primary-foreground)] peer-checked:border-[var(--primary)]">Web Development</span></label></div>
                                <div><label class="cursor-pointer"><input type="checkbox" name="subjects[]" value="Data Science" class="hidden peer"><span class="block text-center p-3 border border-[var(--border)] rounded-lg transition-colors hover:bg-[var(--muted)] peer-checked:bg-[var(--primary)] peer-checked:text-[var(--primary-foreground)] peer-checked:border-[var(--primary)]">Data Science</span></label></div>
                                <div><label class="cursor-pointer"><input type="checkbox" name="subjects[]" value="Python" class="hidden peer"><span class="block text-center p-3 border border-[var(--border)] rounded-lg transition-colors hover:bg-[var(--muted)] peer-checked:bg-[var(--primary)] peer-checked:text-[var(--primary-foreground)] peer-checked:border-[var(--primary)]">Python</span></label></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border card shadow bg-white">
                <div class="flex flex-col space-y-1.5 p-6">
                    <h3 class="font-semibold tracking-tight text-lg flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-[var(--muted-foreground)]"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        Availability
                    </h3>
                    <p class="text-sm text-[var(--muted-foreground)]">
                        Set your weekly availability (you can update this later)
                    </p>
                </div>
                <div class="p-6 pt-0">
                    <div class="space-y-4">
                        <div class="flex flex-wrap items-center gap-4">
                            <div class="flex items-center space-x-2"><input type="checkbox" id="day-0" name="availability[0][enabled]" class="h-4 w-4 rounded border-gray-300 text-[var(--primary)] focus:ring-[var(--primary)]" /><label for="day-0" class="w-20 text-sm font-medium">Monday</label></div>
                            <div class="flex items-center gap-2 flex-1 min-w-[200px]"><input type="time" name="availability[0][startTime]" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2" /><span class="text-[var(--muted-foreground)]">to</span><input type="time" name="availability[0][endTime]" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2" /></div>
                        </div>
                        <div class="flex flex-wrap items-center gap-4">
                            <div class="flex items-center space-x-2"><input type="checkbox" id="day-1" name="availability[1][enabled]" class="h-4 w-4 rounded border-gray-300 text-[var(--primary)] focus:ring-[var(--primary)]" /><label for="day-1" class="w-20 text-sm font-medium">Tuesday</label></div>
                            <div class="flex items-center gap-2 flex-1 min-w-[200px]"><input type="time" name="availability[1][startTime]" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2" /><span class="text-[var(--muted-foreground)]">to</span><input type="time" name="availability[1][endTime]" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2" /></div>
                        </div>
                        <div class="flex flex-wrap items-center gap-4">
                            <div class="flex items-center space-x-2"><input type="checkbox" id="day-2" name="availability[2][enabled]" class="h-4 w-4 rounded border-gray-300 text-[var(--primary)] focus:ring-[var(--primary)]" /><label for="day-2" class="w-20 text-sm font-medium">Wednesday</label></div>
                            <div class="flex items-center gap-2 flex-1 min-w-[200px]"><input type="time" name="availability[2][startTime]" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2" /><span class="text-[var(--muted-foreground)]">to</span><input type="time" name="availability[2][endTime]" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2" /></div>
                        </div>
                        <div class="flex flex-wrap items-center gap-4">
                            <div class="flex items-center space-x-2"><input type="checkbox" id="day-3" name="availability[3][enabled]" class="h-4 w-4 rounded border-gray-300 text-[var(--primary)] focus:ring-[var(--primary)]" /><label for="day-3" class="w-20 text-sm font-medium">Thursday</label></div>
                            <div class="flex items-center gap-2 flex-1 min-w-[200px]"><input type="time" name="availability[3][startTime]" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2" /><span class="text-[var(--muted-foreground)]">to</span><input type="time" name="availability[3][endTime]" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2" /></div>
                        </div>
                        <div class="flex flex-wrap items-center gap-4">
                            <div class="flex items-center space-x-2"><input type="checkbox" id="day-4" name="availability[4][enabled]" class="h-4 w-4 rounded border-gray-300 text-[var(--primary)] focus:ring-[var(--primary)]" /><label for="day-4" class="w-20 text-sm font-medium">Friday</label></div>
                            <div class="flex items-center gap-2 flex-1 min-w-[200px]"><input type="time" name="availability[4][startTime]" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2" /><span class="text-[var(--muted-foreground)]">to</span><input type="time" name="availability[4][endTime]" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2" /></div>
                        </div>
                        <div class="flex flex-wrap items-center gap-4">
                            <div class="flex items-center space-x-2"><input type="checkbox" id="day-5" name="availability[5][enabled]" class="h-4 w-4 rounded border-gray-300 text-[var(--primary)] focus:ring-[var(--primary)]" /><label for="day-5" class="w-20 text-sm font-medium">Saturday</label></div>
                            <div class="flex items-center gap-2 flex-1 min-w-[200px]"><input type="time" name="availability[5][startTime]" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2" /><span class="text-[var(--muted-foreground)]">to</span><input type="time" name="availability[5][endTime]" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2" /></div>
                        </div>
                        <div class="flex flex-wrap items-center gap-4">
                            <div class="flex items-center space-x-2"><input type="checkbox" id="day-6" name="availability[6][enabled]" class="h-4 w-4 rounded border-gray-300 text-[var(--primary)] focus:ring-[var(--primary)]" /><label for="day-6" class="w-20 text-sm font-medium">Sunday</label></div>
                            <div class="flex items-center gap-2 flex-1 min-w-[200px]"><input type="time" name="availability[6][startTime]" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2" /><span class="text-[var(--muted-foreground)]">to</span><input type="time" name="availability[6][endTime]" class="flex h-10 w-full rounded-md border input-field px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2" /></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <a href="/dashboard" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium border border-[var(--border)] h-10 px-4 py-2 bg-transparent hover:bg-[var(--background)] transition-colors">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium h-10 px-4 py-2 bg-[var(--primary)] text-[var(--primary-foreground)] hover:opacity-90 transition-opacity">
                    Create Tutor Profile
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>

