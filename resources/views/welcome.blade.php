<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Card Collector</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@700&family=Fredoka+One&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css'])



</head>

<body class="antialiased">
    <div class="relative lg:flex items-top justify-center min-h-screen bg-neutral-800 sm:items-center py-4 sm:pt-0">
        @if (Route::has('login'))
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            @auth
            <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
            @else
            <a href="{{ route('login') }}" class="text-base text-gray-500 underline">Log in</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="ml-4 text-base text-gray-500 underline">Register</a>
            @endif
            @endauth
        </div>
        @endif


        <div class="justify-self-center lg:flex justify-center pt-8 sm:justify-start sm:pt-0">

            <div> <img src="meerkat.gif"></div>
            <div class="m-auto"> <span class="text-5xl lg:text-9xl text-gray-500 font-amatic font-blac bg-yellow-400">Heart</span>
                <span class=" text-5xl lg:text-9xl text-gray-500 font-amatic font-black bg-blue-800">Stone</span>
                <span class="lg:text-xl ml-2 text-gray-500 font-amatic font-black">Microblogging</span>
            </div>


        </div>

    </div>
</body>

</html>