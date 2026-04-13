@extends('layouts.auth')

@section('title', 'Daftar Akun — E-Ticket Pro')

@section('content')


    <div class="auth-split">

        <a href="{{ url('/') }}" class="auth-back-link">
            <span class="auth-back-link__dot"></span>
            Kembali ke Beranda
        </a>

        {{-- ── Visual panel ── --}}
        <div class="auth-visual">
            <div class="auth-visual__bg"></div>
            <div class="auth-visual__overlay"></div>

            <div class="auth-visual__logo">
                <div class="auth-visual__logo-mark">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.2-1.1.5l-1 2c-.1.3-.1.6.1.8l6.8 5.6-2.5 2.5-4.2-1.3c-.3-.1-.6 0-.8.2l-1 1c-.3.3-.3.7 0 .9l3.5 1.8 1.8 3.5c.2.3.6.3.9 0l1-1c.2-.2.3-.5.2-.8L6.4 17l2.5-2.5 5.6 6.8c.2.2.5.2.8.1l2-1c.3-.2.6-.6.5-1.1z" />
                    </svg>
                </div>
                <span class="auth-visual__logo-text">E-Ticket <strong>Pro</strong></span>
            </div>

            <div class="auth-visual__content">
                <div class="auth-visual__tag">
                    <span class="auth-visual__tag-dot"></span>
                    Gratis & Mudah
                </div>
                <h2 class="auth-visual__headline">
                    Mulai Perjalanan<br>
                    <em>Anda Hari Ini ✈</em>
                </h2>
                <p class="auth-visual__desc">
                    Daftar dalam hitungan detik. Temukan ribuan rute penerbangan dengan harga transparan dan konfirmasi
                    instan.
                </p>
                <div class="auth-visual__stats">
                    <div class="auth-stat">
                        <span class="auth-stat__num">Gratis</span>
                        <span class="auth-stat__label">Daftar</span>
                    </div>
                    <div class="auth-stat">
                        <span class="auth-stat__num">Cepat</span>
                        <span class="auth-stat__label">Konfirmasi</span>
                    </div>
                    <div class="auth-stat">
                        <span class="auth-stat__num">Aman</span>
                        <span class="auth-stat__label">Pembayaran</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Form panel ── --}}
        <div class="auth-form-side">
            <div class="auth-form-container">



                <div class="auth-form-header">
                    <div class="auth-form-eyebrow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                            fill="currentColor">
                            <circle cx="12" cy="12" r="8" />
                        </svg>
                        Akun Baru
                    </div>
                    <h1 class="auth-form-title">Buat Akun</h1>
                    <p class="auth-form-subtitle">Sudah punya akun? <a href="{{ url('/login') }}">Masuk di sini</a></p>
                </div>

                @if($errors->any())
                    <div class="auth-alert auth-alert--error" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                        <ul class="auth-alert__list">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ url('/register') }}" method="POST" class="auth-form" novalidate>
                    @csrf

                    <div class="auth-field">
                        <label class="auth-label" for="name">Nama Lengkap</label>
                        <div class="auth-input-wrap">
                            <span class="auth-input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                            </span>
                            <input type="text" id="name" name="name" class="auth-input @error('name') is-error @enderror"
                                placeholder="Nama lengkap Anda" value="{{ old('name') }}" required autofocus
                                autocomplete="name">
                        </div>
                        @error('name')<span class="auth-field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="auth-field">
                        <label class="auth-label" for="email">Alamat Email</label>
                        <div class="auth-input-wrap">
                            <span class="auth-input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                    <polyline points="22,6 12,13 2,6" />
                                </svg>
                            </span>
                            <input type="email" id="email" name="email"
                                class="auth-input @error('email') is-error @enderror" placeholder="nama@email.com"
                                value="{{ old('email') }}" required autocomplete="email">
                        </div>
                        @error('email')<span class="auth-field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="auth-field">
                        <label class="auth-label" for="password">
                            Kata Sandi
                            <span class="auth-label-hint">Min. 6 karakter</span>
                        </label>
                        <div class="auth-input-wrap">
                            <span class="auth-input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                            </span>
                            <input type="password" id="password" name="password"
                                class="auth-input @error('password') is-error @enderror" placeholder="Buat kata sandi kuat"
                                required autocomplete="new-password">
                            <button type="button" class="auth-toggle-pw" id="toggle-pw" aria-label="Tampilkan password">
                                <svg class="pw-show" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                                <svg class="pw-hide" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" style="display:none">
                                    <path
                                        d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" />
                                    <line x1="1" y1="1" x2="23" y2="23" />
                                </svg>
                            </button>
                        </div>
                        @error('password')<span class="auth-field-error">{{ $message }}</span>@enderror
                        <div class="pw-strength" id="pw-strength">
                            <div class="pw-strength__bar">
                                <div class="pw-strength__fill" id="pw-fill"></div>
                            </div>
                            <span class="pw-strength__label" id="pw-label"></span>
                        </div>
                    </div>

                    <button type="submit" class="auth-submit-btn">
                        <span>Buat Akun Sekarang</span>
                        <span class="auth-submit-btn__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12" />
                                <polyline points="12 5 19 12 12 19" />
                            </svg>
                        </span>
                    </button>
                </form>

                <p class="auth-footer-note">Dengan mendaftar, Anda menyetujui Syarat & Ketentuan layanan E-Ticket Pro.</p>

            </div>
        </div>

    </div>

@endsection

@section('scripts')
    <script>
        (function () {
            const btn = document.getElementById('toggle-pw');
            const inp = document.getElementById('password');
            const fill = document.getElementById('pw-fill');
            const label = document.getElementById('pw-label');

            if (btn && inp) {
                btn.addEventListener('click', () => {
                    const show = inp.type === 'text';
                    inp.type = show ? 'password' : 'text';
                    btn.querySelector('.pw-show').style.display = show ? '' : 'none';
                    btn.querySelector('.pw-hide').style.display = show ? 'none' : '';
                });
            }

            const strengths = [
                { label: 'Sangat Lemah', color: '#ef4444', width: '20%' },
                { label: 'Lemah', color: '#f97316', width: '40%' },
                { label: 'Cukup', color: '#eab308', width: '60%' },
                { label: 'Kuat', color: '#22c55e', width: '80%' },
                { label: 'Sangat Kuat', color: '#10b981', width: '100%' },
            ];

            function calcStrength(pw) {
                let s = 0;
                if (pw.length >= 6) s++;
                if (pw.length >= 10) s++;
                if (/[A-Z]/.test(pw)) s++;
                if (/[0-9]/.test(pw)) s++;
                if (/[^A-Za-z0-9]/.test(pw)) s++;
                return Math.min(s, 4);
            }

            if (inp && fill && label) {
                inp.addEventListener('input', () => {
                    const pw = inp.value;
                    if (!pw) { fill.style.width = '0'; label.textContent = ''; return; }
                    const st = strengths[calcStrength(pw)];
                    fill.style.width = st.width;
                    fill.style.background = st.color;
                    label.textContent = st.label;
                    label.style.color = st.color;
                });
            }
        })();
    </script>
@endsection
