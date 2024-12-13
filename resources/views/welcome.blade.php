@php
    if (auth()->check()) {
        // Logs out the user
        auth()->logout();

        // Invalidate the session
        request()->session()->invalidate();

        // Regenerate the session token
        request()->session()->regenerateToken();
    }
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ilearn</title>
</head>

<body>
    <h1>This is the welcome screen. Hello, hi!</h1>
    <a href="{{ route('login') }}"
        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
        Log in
    </a>
</body>

</html>
