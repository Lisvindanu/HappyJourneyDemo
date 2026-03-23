<!DOCTYPE html>
<html lang="id" style="overflow-x:hidden;max-width:100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Happy Journey - Tour & Travel terpercaya. Paket wisata domestik dan internasional dengan kualitas premium dan harga kompetitif.')">
    <meta name="keywords" content="@yield('meta_keywords', 'happy journey, tour travel, paket wisata, jepang, korea, china, eropa, vietnam')">

    {{-- Open Graph --}}
    <meta property="og:site_name" content="Happy Journey Tour & Travel">
    <meta property="og:title" content="@yield('title', 'Happy Journey Tour & Travel') | Happy Journey">
    <meta property="og:description" content="@yield('meta_description', 'Happy Journey - Tour & Travel terpercaya. Paket wisata domestik dan internasional dengan kualitas premium dan harga kompetitif.')">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('images/og-image.webp'))">
    <meta property="og:image:type" content="image/webp">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="id_ID">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Happy Journey Tour & Travel')">
    <meta name="twitter:description" content="@yield('meta_description', 'Happy Journey - Tour & Travel terpercaya.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/og-image.webp'))">

    <title>@yield('title', 'Happy Journey Tour & Travel') | It\'s Not Just Travel, It\'s a Happy Journey</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo/cropped-logo_happy_journey.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo/cropped-logo_happy_journey.png') }}">

    {{-- Google Fonts: Poppins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- AOS CSS CDN --}}
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">

    {{-- Vite CSS --}}
    @vite(['resources/css/app.css'])

    @stack('head')
</head>
<body class="font-sans antialiased bg-white text-slate-800 min-h-screen flex flex-col" style="overflow-x:hidden;max-width:100%;width:100%;">

    {{-- Main content --}}
    <div id="app" class="flex flex-col min-h-screen">
        @yield('content')
    </div>

    {{-- Alpine.js CDN (defer) --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- AOS JS CDN --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            AOS.init({
                duration: 700,
                once: true,
                offset: 60,
                easing: 'ease-out-cubic',
            });
        });
    </script>

    {{-- Vite JS --}}
    @vite(['resources/js/app.js'])

    @stack('scripts')
</body>
</html>
