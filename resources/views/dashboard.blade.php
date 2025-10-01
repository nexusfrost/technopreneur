<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    {{-- Alpine.js for interactivity --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Basic Tailwind Config to mimic the original theme --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        border: 'hsl(214.3 31.8% 91.4%)',
                        input: 'hsl(214.3 31.8% 91.4%)',
                        ring: 'hsl(214.3 31.8% 91.4%)',
                        background: 'hsl(0 0% 100%)',
                        foreground: 'hsl(222.2 84% 4.9%)',
                        primary: {
                            DEFAULT: 'hsl(222.2 47.4% 11.2%)',
                            foreground: 'hsl(210 40% 98%)',
                        },
                        secondary: {
                            DEFAULT: 'hsl(210 40% 96.1%)',
                            foreground: 'hsl(222.2 47.4% 11.2%)',
                        },
                        muted: {
                            DEFAULT: 'hsl(210 40% 96.1%)',
                            foreground: 'hsl(215.4 16.3% 46.9%)',
                        },
                        accent: {
                            DEFAULT: 'hsl(210 40% 96.1%)',
                            foreground: 'hsl(222.2 47.4% 11.2%)',
                        },
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-background text-foreground">

    @php
    // Helper function for status colors
    function getStatusColor($status) {
        switch ($status) {
            case 'confirmed': return 'bg-green-100 text-green-800';
            case 'pending': return 'bg-yellow-100 text-yellow-800';
            case 'completed': return 'bg-blue-100 text-blue-800';
            case 'cancelled': return 'bg-red-100 text-red-800';
            default: return 'bg-gray-100 text-gray-800';
        }
    }
    // Dummy data for testing the view without a controller
    $tutorProfile = (object)['name' => 'John Doe']; // Set to null to test the other view state
    $myBookings = []; // Leave empty or populate with dummy objects to test
    @endphp

    <div class="min-h-screen"
        x-data="{
            userEditOpen: false,
            tutorEditOpen: false,
            activeTab: 'bookings'
        }">

        <div class="container mx-auto px-4 py-8 max-w-6xl">
            {{-- Header --}}
            <div class="flex flex-wrap justify-between items-center mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">Dashboard</h1>
                    <p class="text-muted-foreground mt-1">
                        Welcome back, {{ Auth::user()->name }}!
                    </p>
                </div>
                <div class="flex gap-3">
                    <button @click="userEditOpen = true" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Edit Profile
                    </button>

                    <a href="#" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                        Browse Tutors
                    </a>

                    @if(empty($tutorProfile))
                        <a href="#" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Become a Tutor
                        </a>
                    @endif
                </div>
            </div>

            {{-- Tabs --}}
            <div class="space-y-6">
                <div class="inline-flex h-9 items-center justify-center rounded-lg bg-muted p-1 text-muted-foreground w-full grid-cols-2">
                    <button @click="activeTab = 'bookings'" :class="{'bg-background text-foreground shadow-sm': activeTab === 'bookings'}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1.5 text-sm font-medium ring-offset-background transition-all w-full">My Bookings</button>
                    <button @click="activeTab = 'tutor'" :disabled="{{ empty($tutorProfile) ? 'true' : 'false' }}" :class="{'bg-background text-foreground shadow-sm': activeTab === 'tutor'}" class="inline-flex items-center justify-center whitespace-nowrap rounded-md px-3 py-1.5 text-sm font-medium ring-offset-background transition-all w-full disabled:pointer-events-none disabled:opacity-50">Tutor Dashboard</button>
                </div>

                {{-- My Bookings Content --}}
                <div x-show="activeTab === 'bookings'" class="space-y-6">
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="p-6">
                            @if(empty($myBookings))
                                <div class="text-center py-8">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-12 h-12 mx-auto text-muted-foreground mb-4"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                    <p class="text-muted-foreground mb-4">No bookings yet</p>
                                    <a href="#" class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                                        Find a Tutor
                                    </a>
                                </div>
                            @endif
                            {{-- Loop would go here --}}
                        </div>
                    </div>
                </div>

                {{-- Tutor Dashboard Content --}}
                <div x-show="activeTab === 'tutor'" class="space-y-6">
                    @if(!empty($tutorProfile))
                        <div class="flex justify-end">
                            <button @click="tutorEditOpen = true" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                Edit Tutor Profile
                            </button>
                        </div>
                        <p class="text-center text-muted-foreground p-8">Tutor dashboard content would be here.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Modals would go here --}}
    </div>

</body>
</html>
