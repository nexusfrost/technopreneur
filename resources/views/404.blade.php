<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TutorHub - Page Not Found</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* * =================================================================
         * CUSTOMIZED COLOR PALETTE (from other pages)
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
    <div class="text-center">
        <a href="/" class="inline-block mb-8">
            <img src="{{ asset('logo_tutorhub.png') }}" alt="Logo" class="rounded-lg w-52"/>
        </a>
        <h1 class="text-8xl font-bold text-[var(--primary)] tracking-tighter">404</h1>
        <h2 class="text-3xl font-semibold text-[var(--foreground)] mt-4 mb-2">Page Not Found</h2>
        <p class="text-lg text-[var(--muted-foreground)] mb-8">
            Sorry, we couldn't find the page you're looking for.
        </p>
        <a href="/" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium h-10 px-6 py-2 bg-[var(--primary)] text-[var(--primary-foreground)] hover:opacity-90 transition-colors">
            Go Back Home
        </a>
    </div>
</div>

</body>
</html>
