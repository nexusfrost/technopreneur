<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TutorHub - Authentication</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* * =================================================================
         * CUSTOMIZED COLOR PALETTE (from landing page)
         * =================================================================
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
    </style>
</head>
<body class="bg-[var(--muted)] text-[var(--foreground)]">

<div class="min-h-screen flex flex-col items-center justify-center px-4">
    <div class="rounded-lg border border-[var(--border)]/50 bg-[var(--background)] text-[var(--foreground)] shadow-lg w-full max-w-sm">
        <div class="flex flex-col p-6 space-y-1 text-center">
            <div class="flex justify-center">
                <a href="/">
                    <img src="{{ asset("logo_tutorhub.png") }}" alt="Logo" class="rounded-lg mb-4 cursor-pointer w-52"/>
                </a>
            </div>
            <h3 class="font-semibold tracking-tight text-2xl">Welcome Back</h3>
            <p class="text-sm text-[var(--muted-foreground)]">
                Enter your credentials to access your account
            </p>
        </div>

        <form action="/login" method="POST">
            <div class="p-6 pt-0 space-y-4">
                <!-- Email Input -->
                <div class="space-y-2">
                    <label for="email" class="text-sm font-medium leading-none">Email</label>
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-[var(--muted-foreground)]/80">
                            <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                        </svg>
                        <input id="email" name="email" placeholder="name@example.com" type="email" class="flex h-10 w-full rounded-md border border-[var(--border)] bg-transparent px-3 py-2 text-sm pl-10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--primary)]" required />
                    </div>
                </div>

                <!-- Password Input -->
                <div class="space-y-2">
                     <label for="password" class="text-sm font-medium leading-none">Password</label>
                    <div class="relative">
                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-[var(--muted-foreground)]/80">
                           <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                           <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                       </svg>
                        <input id="password" name="password" type="password" placeholder="••••••••" class="flex h-10 w-full rounded-md border border-[var(--border)] bg-transparent px-3 py-2 text-sm pl-10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--primary)]" required />
                    </div>
                </div>

                <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium h-10 px-4 py-2 w-full bg-[var(--primary)] text-[var(--primary-foreground)] hover:opacity-90 transition-colors">
                    Login
                </button>
            </div>
        </form>

        <div class="p-6 pt-4 text-center text-sm">
            <p class="text-[var(--muted-foreground)]">
                Don't have an account?
                <a href="/register" class="font-semibold text-[var(--primary)] hover:underline">
                    Register here!
                </a>
            </p>
        </div>
    </div>
</div>

</body>
</html>

