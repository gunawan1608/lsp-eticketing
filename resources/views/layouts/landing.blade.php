<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description"
        content="E-Ticket Pro - Platform pemesanan tiket pesawat online terpercaya dengan proses cepat, harga transparan, dan konfirmasi instan.">
    <title>@yield('title', 'E-Ticket Pro - Pesan Tiket Pesawat')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">

    @yield('styles')
</head>

<body class="lp-body">

    <header class="lp-nav" role="banner">
        <div class="lp-nav__inner">
            <a href="{{ url('/') }}" class="lp-nav__brand" aria-label="Beranda E-Ticket Pro">
                <div class="lp-nav__logo-mark" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.2-1.1.5l-1 2c-.1.3-.1.6.1.8l6.8 5.6-2.5 2.5-4.2-1.3c-.3-.1-.6 0-.8.2l-1 1c-.3.3-.3.7 0 .9l3.5 1.8 1.8 3.5c.2.3.6.3.9 0l1-1c.2-.2.3-.5.2-.8L6.4 17l2.5-2.5 5.6 6.8c.2.2.5.2.8.1l2-1c.3-.2.6-.6.5-1.1z">
                        </path>
                    </svg>
                </div>
                <span class="lp-nav__brand-text">E-Ticket <strong>Pro</strong></span>
            </a>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    @yield('scripts')
</body>

</html>
