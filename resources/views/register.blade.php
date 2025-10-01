<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .text-primary { color: #3b82f6; }
        .bg-primary { background-color: #3b82f6; }
        .border-primary { border-color: #3b82f6; }
        .ring-primary:focus { --tw-ring-color: #3b82f6; }
    </style>
</head>
<body class="bg-white text-gray-800">

<div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 px-4">
    <div class="rounded-lg border bg-white text-gray-900 shadow-lg w-full max-w-sm">
        <div class="flex flex-col p-6 space-y-1 text-center">
            <div class="flex justify-center">
                <a href="/">
                    <img src="https://via.placeholder.com/64" alt="Logo" class="rounded-lg mb-4 cursor-pointer" />
                </a>
            </div>
            <h3 class="font-semibold tracking-tight text-2xl">Create an Account</h3>
            <p class="text-sm text-gray-500">
                Enter your details below to get started
            </p>
        </div>

        <form action="{{ route("createUser") }}" method="POST">
            @csrf
            <div class="p-6 pt-0 space-y-4">
                {{-- Full Name Input --}}
                <div class="space-y-2">
                    <label for="name" class="text-sm font-medium leading-none">Full Name</label>
                    <div class="relative">
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <input id="name" name="name" placeholder="John Doe" type="text" class="flex h-10 w-full rounded-md border bg-transparent px-3 py-2 text-sm pl-10 focus:outline-none focus:ring-2 focus:ring-offset-2 ring-primary" required />
                    </div>
                </div>

                {{-- Email Input --}}
                <div class="space-y-2">
                    <label for="email" class="text-sm font-medium leading-none">Email</label>
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400">
                            <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                        </svg>
                        <input id="email" name="email" placeholder="name@example.com" type="email" class="flex h-10 w-full rounded-md border bg-transparent px-3 py-2 text-sm pl-10 focus:outline-none focus:ring-2 focus:ring-offset-2 ring-primary" required />

                    </div>
                    @error('email')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password Input --}}
                <div class="space-y-2">
                     <label for="password" class="text-sm font-medium leading-none">Password</label>
                    <div class="relative">
                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400">
                           <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                           <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                       </svg>
                        <input id="password" name="password" type="password" placeholder="••••••••" class="flex h-10 w-full rounded-md border bg-transparent px-3 py-2 text-sm pl-10 focus:outline-none focus:ring-2 focus:ring-offset-2 ring-primary" required />

                    </div>
                    @error('password')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirm Password Input --}}
                <div class="space-y-2">
                     <label for="password_confirmation" class="text-sm font-medium leading-none">Confirm Password</label>
                    <div class="relative">
                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400">
                           <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                           <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                       </svg>
                        <input id="password_confirmation" name="password_confirmation" type="password" placeholder="••••••••" class="flex h-10 w-full rounded-md border bg-transparent px-3 py-2 text-sm pl-10 focus:outline-none focus:ring-2 focus:ring-offset-2 ring-primary" required />

                    </div>
                    @error('password_confirmation')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>

                    @enderror
                </div>

                <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium h-10 px-4 py-2 w-full bg-gray-900 text-white hover:bg-gray-800 transition-colors">
                    Register
                </button>
            </div>
        </form>

        <div class="p-6 pt-4 text-center text-sm">
            <p class="text-gray-600">
                Already have an account?
                <a href="/auth" class="font-semibold text-primary hover:underline">
                    Login here!
                </a>
            </p>
        </div>
    </div>
</div>

</body>
</html>
