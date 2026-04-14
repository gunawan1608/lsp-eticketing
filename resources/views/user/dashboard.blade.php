@extends('layouts.app')

@section('title', 'Jadwal Penerbangan - E-Ticket Pro')

@section('styles')
    <style>
        .dash-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.75rem;
            flex-wrap: wrap;
        }

        .dash-title-block {
            min-width: 0;
        }

        .dash-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--r-600);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 0.25rem;
        }

        .dash-eyebrow span {
            width: 5px;
            height: 5px;
            background: var(--r-500);
            border-radius: 50%;
            flex-shrink: 0;
        }

        .dash-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--n-900);
            letter-spacing: -0.035em;
            margin: 0;
            line-height: 1.15;
        }

        /* Pencarian */
        .search-wrap {
            display: flex;
            align-items: center;
            gap: 0;
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 0.75rem;
            overflow: hidden;
            max-width: 380px;
            width: 100%;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .search-wrap:focus-within {
            border-color: var(--r-400);
            box-shadow: 0 0 0 3px rgba(244, 63, 94, .10);
        }

        .search-icon {
            padding: 0 0.75rem 0 0.875rem;
            color: var(--n-400);
            display: flex;
            align-items: center;
            flex-shrink: 0;
        }

        .search-input {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
            font-size: 0.875rem;
            color: var(--n-900);
            font-family: inherit;
            padding: 0.6rem 0;
        }

        .search-input::placeholder {
            color: var(--n-400);
        }

        .search-btn {
            border: none;
            border-left: 1px solid var(--n-200);
            background: var(--r-600);
            color: #fff;
            padding: 0.6rem 1rem;
            font-size: 0.8125rem;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
            transition: background 0.15s;
            font-family: inherit;
        }

        .search-btn:hover {
            background: var(--r-700);
        }

        .reset-link {
            font-size: 0.8125rem;
            color: var(--n-400);
            text-decoration: none;
            padding: 0.6rem 0.5rem;
            transition: color 0.15s;
            white-space: nowrap;
        }

        .reset-link:hover {
            color: var(--r-600);
        }

        /* Daftar penerbangan */
        .fl-list {
            display: flex;
            flex-direction: column;
            gap: 0.625rem;
        }

        .fl-item {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 1rem;
            display: grid;
            grid-template-columns: 1fr auto auto auto;
            gap: 1.25rem;
            align-items: center;
            padding: 1.25rem 1.5rem;
            transition: border-color 0.18s, box-shadow 0.18s, transform 0.18s;
        }

        .fl-item:hover {
            border-color: var(--r-200);
            box-shadow: 0 4px 20px rgba(225, 29, 72, .07);
            transform: translateY(-1px);
        }

        /* Informasi penerbangan */
        .fi-plane {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--n-400);
            margin-bottom: 0.5rem;
        }

        .fi-route {
            display: flex;
            align-items: center;
            gap: 0.625rem;
        }

        .fi-code {
            font-size: 1.5rem;
            font-weight: 900;
            color: var(--n-900);
            letter-spacing: -0.04em;
            line-height: 1;
        }

        .fi-arrow {
            color: var(--n-300);
            display: flex;
            align-items: center;
        }

        .fi-city {
            font-size: 0.78rem;
            color: var(--n-400);
            margin-top: 0.2rem;
            max-width: 180px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Waktu */
        .fi-time {
            text-align: right;
        }

        .fi-time-val {
            font-size: 1rem;
            font-weight: 700;
            color: var(--n-900);
        }

        .fi-time-date {
            font-size: 0.78rem;
            color: var(--n-500);
            margin-top: 0.1rem;
        }

        .fi-time-note {
            font-size: 0.72rem;
            color: var(--n-400);
            margin-top: 0.1rem;
        }

        /* Harga */
        .fi-price {
            text-align: right;
            min-width: 110px;
        }

        .fi-price-label {
            font-size: 0.72rem;
            color: var(--n-400);
            font-weight: 500;
        }

        .fi-price-val {
            font-size: 1.0625rem;
            font-weight: 800;
            color: var(--r-600);
            letter-spacing: -0.02em;
            white-space: nowrap;
        }

        /* Aksi */
        .fi-action {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 0.5rem;
            min-width: 90px;
        }

        /* Availability badges */
        .avail-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.625rem;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .avail-badge--avail {
            background: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .avail-badge--low {
            background: var(--r-50);
            color: var(--r-600);
            border: 1px solid var(--r-200);
        }

        .avail-badge--full {
            background: var(--n-100);
            color: var(--n-500);
            border: 1px solid var(--n-200);
        }

        .avail-badge--exp {
            background: var(--n-100);
            color: var(--n-500);
            border: 1px solid var(--n-200);
        }

        /* Tombol pemesanan */
        .book-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.375rem;
            padding: 0.5rem 1.125rem;
            border-radius: 0.625rem;
            font-size: 0.8125rem;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.18s;
            font-family: inherit;
            white-space: nowrap;
        }

        .book-btn--active {
            background: var(--r-600);
            color: #fff;
            box-shadow: 0 3px 12px rgba(225, 29, 72, .25);
        }

        .book-btn--active:hover {
            background: var(--r-700);
            transform: translateY(-1px);
            box-shadow: 0 5px 16px rgba(225, 29, 72, .32);
        }

        .book-btn--disabled {
            background: var(--n-100);
            color: var(--n-400);
            cursor: not-allowed;
        }

        /* Empty */
        .empty-box {
            text-align: center;
            padding: 4rem 2rem;
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 1rem;
            color: var(--n-400);
        }

        .empty-box svg {
            width: 44px;
            height: 44px;
            color: var(--n-200);
            margin-bottom: 1rem;
        }

        .empty-box h3 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--n-600);
            margin-bottom: 0.375rem;
        }

        .empty-box p {
            font-size: 0.875rem;
        }

        @media (max-width: 768px) {
            .fl-item {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .fi-time,
            .fi-price,
            .fi-action {
                text-align: left;
                align-items: flex-start;
            }

            .dash-header {
                flex-direction: column;
                align-items: stretch;
            }

            .search-wrap {
                max-width: 100%;
            }
        }
    </style>
@endsection

@section('content')

<div class="dash-header">
    <div class="dash-title-block">
        <div class="dash-eyebrow"><span></span> Penerbangan Tersedia</div>
        <h1 class="dash-title">Jadwal Penerbangan</h1>
    </div>

    <form action="{{ route('dashboard') }}" method="GET" style="display:contents;">
        <input type="hidden" name="page" value="1">
        <div class="search-wrap">
            <span class="search-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
            </span>
            <input type="text" name="search" class="search-input" value="{{ $search ?? '' }}"
                placeholder="Cari pesawat, asal, atau tujuan">
            @if(filled($search ?? ''))
                <a href="{{ route('dashboard') }}" class="reset-link">Atur Ulang</a>
            @endif
            <button type="submit" class="search-btn">Cari</button>
        </div>
    </form>
</div>

@if($schedules->isEmpty())
    <div class="empty-box">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
            stroke-linecap="round" stroke-linejoin="round">
            <path
                d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.2-1.1.5l-1 2c-.1.3-.1.6.1.8l6.8 5.6-2.5 2.5-4.2-1.3c-.3-.1-.6 0-.8.2l-1 1c-.3.3-.3.7 0 .9l3.5 1.8 1.8 3.5c.2.3.6.3.9 0l1-1c.2-.2.3-.5.2-.8L6.4 17l2.5-2.5 5.6 6.8c.2.2.5.2.8.1l2-1c.3-.2.6-.6.5-1.1z" />
        </svg>
        <h3>Tidak ada jadwal ditemukan</h3>
        <p>Coba ubah kata kunci pencarian Anda</p>
    </div>
@else
<div class="fl-list">
    @foreach($schedules as $item)
    @php($isExpired = $item->isExpired())
    @php($isBookable = $item->isBookable())

    <div class="fl-item" data-schedule-row data-departure="{{ $item->departure->toIso8601String() }}"
        data-stock="{{ $item->stock }}">

        <div>
            <div class="fi-plane">
                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.2-1.1.5l-1 2c-.1.3-.1.6.1.8l6.8 5.6-2.5 2.5-4.2-1.3c-.3-.1-.6 0-.8.2l-1 1c-.3.3-.3.7 0 .9l3.5 1.8 1.8 3.5c.2.3.6.3.9 0l1-1c.2-.2.3-.5.2-.8L6.4 17l2.5-2.5 5.6 6.8c.2.2.5.2.8.1l2-1c.3-.2.6-.6.5-1.1z" />
                </svg>
                {{ $item->plane_name }}
            </div>
            <div class="fi-route">
                <div>
                    <div class="fi-code">{{ strtoupper(substr($item->origin, 0, 3)) }}</div>
                </div>
                <div class="fi-arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12" />
                        <polyline points="12 5 19 12 12 19" />
                    </svg>
                </div>
                <div>
                    <div class="fi-code">{{ strtoupper(substr($item->destination, 0, 3)) }}</div>
                </div>
            </div>
            <div class="fi-city">{{ $item->origin }} → {{ $item->destination }}</div>
        </div>

        <div class="fi-time">
            <div class="fi-time-val">{{ $item->departure->format('H:i') }}</div>
            <div class="fi-time-date">{{ $item->departure->format('d M Y') }}</div>
            <div class="fi-time-note" data-departure-note>
                {{ $isExpired ? 'Sudah lewat' : $item->departure->diffForHumans() }}
            </div>
        </div>

        <div class="fi-price">
            <div class="fi-price-label">per kursi</div>
            <div class="fi-price-val">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
        </div>

        <div class="fi-action">
            <span class="avail-badge {{ $item->availability_badge_class }}" data-availability-badge>
                {{ $item->availability_label }}
            </span>
            <button type="button" class="book-btn {{ $isBookable ? 'book-btn--active' : 'book-btn--disabled' }}"
                data-booking-cta data-booking-url="{{ route('booking.index', $item->id) }}" {{ !$isBookable ? 'disabled' : '' }}>
                {{ $isExpired ? 'Kadaluarsa' : ($item->stock > 0 ? 'Pesan Tiket' : 'Penuh') }}
            </button>
        </div>
    </div>
    @endforeach
</div>

@include('partials.pagination', ['paginator' => $schedules])
@endif

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const rows = document.querySelectorAll('[data-schedule-row]');

            rows.forEach(row => {
                const btn = row.querySelector('[data-booking-cta]');
                if (btn) {
                    btn.addEventListener('click', function () {
                        if (!this.disabled && this.dataset.bookingUrl) {
                            window.location.href = this.dataset.bookingUrl;
                        }
                    });
                }
            });

            function updateState() {
                const now = new Date();
                rows.forEach(row => {
                    const departure = new Date(row.dataset.departure);
                    const stock = Number(row.dataset.stock || 0);
                    const badge = row.querySelector('[data-availability-badge]');
                    const note = row.querySelector('[data-departure-note]');
                    const btn = row.querySelector('[data-booking-cta]');
                    if (!badge || !note || !btn) return;

                    if (departure <= now) {
                        badge.textContent = 'Kadaluarsa';
                        badge.className = 'avail-badge avail-badge--exp';
                        note.textContent = 'Sudah lewat';
                        btn.textContent = 'Kadaluarsa';
                        btn.className = 'book-btn book-btn--disabled';
                        btn.disabled = true;
                        return;
                    }

                    if (stock <= 0) {
                        badge.textContent = 'Penuh';
                        badge.className = 'avail-badge avail-badge--full';
                        btn.textContent = 'Penuh';
                        btn.className = 'book-btn book-btn--disabled';
                        btn.disabled = true;
                        return;
                    }

                    badge.textContent = stock > 10 ? `${stock} Kursi` : `Sisa ${stock}`;
                    badge.className = stock > 10 ? 'avail-badge avail-badge--avail' : 'avail-badge avail-badge--low';
                    btn.textContent = 'Pesan Tiket';
                    btn.className = 'book-btn book-btn--active';
                    btn.disabled = false;
                });
            }

            updateState();
            setInterval(updateState, 30000);
        });
    </script>
@endsection
