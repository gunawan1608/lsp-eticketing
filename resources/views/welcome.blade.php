@extends('layouts.landing')

@section('title', 'E-Ticket Pro - Pesan Tiket Pesawat Cepat dan Mudah')

@section('content')
<section class="lp-hero" id="hero">
    <div class="lp-hero__overlay"></div>

    <div class="lp-hero__content">
        <div class="lp-hero__badge">
            <span class="lp-hero__badge-dot"></span>
            Platform E-Tiket Terpercaya
        </div>

        <h1 class="lp-hero__title">
            Terbang ke Mana Saja,
            <span class="lp-hero__title-highlight">Pesan dalam Hitungan Menit</span>
        </h1>

        <p class="lp-hero__subtitle">
            Pemesanan tiket pesawat dengan harga transparan,
            konfirmasi instan, dan rute domestik maupun internasional.
        </p>

        <div class="lp-hero__actions">
            @auth
                @if(Auth::user()->isAdmin())
                    <a href="{{ url('/dashboard') }}" class="lp-btn lp-btn--primary" id="hero-cta-admin">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        Buka Dasbor Admin
                    </a>
                @else
                    <a href="{{ url('/dashboard') }}" class="lp-btn lp-btn--primary" id="hero-cta-book">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.2-1.1.5l-1 2c-.1.3-.1.6.1.8l6.8 5.6-2.5 2.5-4.2-1.3c-.3-.1-.6 0-.8.2l-1 1c-.3.3-.3.7 0 .9l3.5 1.8 1.8 3.5c.2.3.6.3.9 0l1-1c.2-.2.3-.5.2-.8L6.4 17l2.5-2.5 5.6 6.8c.2.2.5.2.8.1l2-1c.3-.2.6-.6.5-1.1z"></path></svg>
                        Cari &amp; Pesan Tiket
                    </a>
                @endif
            @else
                <a href="{{ url('/login') }}" class="lp-btn lp-btn--primary" id="hero-cta-login">
                    Mulai Sekarang
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </a>
                <a href="{{ url('/register') }}" class="lp-btn lp-btn--ghost" id="hero-cta-register">
                    Daftar Akun
                </a>
            @endauth
        </div>

        <div class="lp-hero__trust" aria-label="Keunggulan utama">
            <div class="trust-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                <span>Terpercaya</span>
            </div>
            <div class="trust-divider"></div>
            <div class="trust-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                <span>Pembayaran Aman</span>
            </div>
            <div class="trust-divider"></div>
            <div class="trust-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                <span>Harga Terbaik</span>
            </div>
        </div>
    </div>
</section>
@endsection
