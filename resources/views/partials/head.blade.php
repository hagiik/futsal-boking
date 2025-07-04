<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ $title . ' - ' . config('app.name') ?? config('app.name') }}</title>

<link rel="icon" href="{{asset('images/GilSports.svg')}}" sizes="any">
<link rel="icon" href="{{asset('images/GilSports.svg')}}" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
