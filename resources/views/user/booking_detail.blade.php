@extends('layouts.app')

@section('title', 'Pesan Tiket - E-Ticket Pro')

@section('styles')
    <style>
        .bk-wrap {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 1.5rem;
            align-items: start;
        }

        /* Flight info card */
        .fi-card {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 1.25rem;
            overflow: hidden;
        }

        .fi-card-head {
            padding: 1.125rem 1.5rem;
            border-bottom: 1.5px solid var(--n-100);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .fi-card-head h2 {
            font-size: 1.0625rem;
            font-weight: 800;
            color: var(--n-900);
            letter-spacing: -0.02em;
            margin: 0;
        }

        .avail-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.25rem 0.625rem;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 600;
            background: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .fi-card-body {
            padding: 1.5rem;
        }

        /* Route strip */
        .route-strip {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.375rem 1.5rem;
            background: linear-gradient(135deg, #fff1f2 0%, #fafafa 100%);
            border-radius: 0.875rem;
            margin-bottom: 1.5rem;
        }

        .rsp {
            flex: 1;
        }

        .rsp-code {
            font-size: 2.25rem;
            font-weight: 900;
            color: var(--r-600);
            letter-spacing: -0.04em;
            line-height: 1;
        }

        .rsp-city {
            font-size: 0.8125rem;
            color: var(--n-500);
            margin-top: 0.25rem;
        }

        .rsp--right {
            text-align: right;
        }

        .route-mid {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.375rem;
        }

        .route-mid-line {
            width: 100%;
            height: 1.5px;
            background: repeating-linear-gradient(90deg, var(--n-300) 0, var(--n-300) 5px, transparent 5px, transparent 10px);
        }

        .route-mid svg {
            color: var(--r-400);
        }

        /* Detail grid */
        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
        }

        .detail-label {
            font-size: 0.72rem;
            color: var(--n-400);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .detail-value {
            font-size: 0.9375rem;
            font-weight: 700;
            color: var(--n-900);
        }

        /* Summary card */
        .sum-card {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 1.25rem;
            overflow: hidden;
            position: sticky;
            top: 80px;
        }

        .sum-head {
            padding: 1.125rem 1.5rem;
            border-bottom: 1.5px solid var(--n-100);
        }

        .sum-head h3 {
            font-size: 1.0625rem;
            font-weight: 800;
            color: var(--n-900);
            margin: 0;
            letter-spacing: -0.02em;
        }

        .sum-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        /* Seat counter */
        .seat-section {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .seat-label {
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--n-600);
        }

        .seat-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .seat-btn {
            width: 40px;
            height: 40px;
            border-radius: 0.625rem;
            border: 1.5px solid var(--border);
            background: var(--n-50);
            color: var(--n-600);
            font-size: 1.25rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s;
            flex-shrink: 0;
            line-height: 1;
        }

        .seat-btn:hover {
            border-color: var(--r-400);
            color: var(--r-600);
            background: var(--r-50);
        }

        .seat-input {
            flex: 1;
            text-align: center;
            font-size: 1.375rem;
            font-weight: 800;
            color: var(--n-900);
            border: 1.5px solid var(--border);
            border-radius: 0.625rem;
            padding: 0.5rem;
            font-family: inherit;
            outline: none;
            transition: border-color 0.2s;
            -moz-appearance: textfield;
        }

        .seat-input:focus {
            border-color: var(--r-400);
            box-shadow: 0 0 0 3px rgba(244, 63, 94, .10);
        }

        .seat-input::-webkit-inner-spin-button,
        .seat-input::-webkit-outer-spin-button {
            -webkit-appearance: none;
        }

        .seat-hint {
            font-size: 0.72rem;
            color: var(--n-400);
        }

        /* Total box */
        .total-box {
            background: var(--r-50);
            border-radius: 0.875rem;
            padding: 1rem 1.25rem;
            border: 1px solid var(--r-100);
        }

        .total-label {
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--r-600);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 0.25rem;
        }

        .total-amount {
            font-size: 1.75rem;
            font-weight: 900;
            color: var(--r-600);
            letter-spacing: -0.04em;
            line-height: 1.1;
        }

        /* Submit */
        .submit-btn {
            width: 100%;
            padding: 0.875rem;
            background: var(--r-600);
            color: #fff;
            border: none;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            box-shadow: var(--shadow-red);
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .submit-btn:hover {
            background: var(--r-700);
            transform: translateY(-1px);
            box-shadow: 0 7px 22px rgba(225, 29, 72, .30);
        }

        @media (max-width: 768px) {
            .bk-wrap {
                grid-template-columns: 1fr;
            }

            .sum-card {
                position: static;
            }

            .detail-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')

    <a href="{{ url('/dashboard') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12" />
            <polyline points="12 19 5 12 12 5" />
        </svg>
        Kembali ke Jadwal
    </a>

    <div class="bk-wrap">

        <!-- Flight info -->
        <div class="fi-card">
            <div class="fi-card-head">
                <h2>Detail Penerbangan</h2>
                <span class="avail-chip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 24 24" fill="currentColor">
                        <circle cx="12" cy="12" r="10" />
                    </svg>
                    {{ $schedule->stock }} kursi tersedia
                </span>
            </div>
            <div class="fi-card-body">
                <div class="route-strip">
                    <div class="rsp">
                        <div class="rsp-code">{{ strtoupper(substr($schedule->origin, 0, 3)) }}</div>
                        <div class="rsp-city">{{ $schedule->origin }}</div>
                    </div>
                    <div class="route-mid">
                        <div class="route-mid-line"></div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.2-1.1.5l-1 2c-.1.3-.1.6.1.8l6.8 5.6-2.5 2.5-4.2-1.3c-.3-.1-.6 0-.8.2l-1 1c-.3.3-.3.7 0 .9l3.5 1.8 1.8 3.5c.2.3.6.3.9 0l1-1c.2-.2.3-.5.2-.8L6.4 17l2.5-2.5 5.6 6.8c.2.2.5.2.8.1l2-1c.3-.2.6-.6.5-1.1z" />
                        </svg>
                        <div class="route-mid-line"></div>
                    </div>
                    <div class="rsp rsp--right">
                        <div class="rsp-code">{{ strtoupper(substr($schedule->destination, 0, 3)) }}</div>
                        <div class="rsp-city">{{ $schedule->destination }}</div>
                    </div>
                </div>

                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">Pesawat</span>
                        <span class="detail-value">{{ $schedule->plane_name }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Keberangkatan</span>
                        <span
                            class="detail-value">{{ \Carbon\Carbon::parse($schedule->departure)->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Harga per Kursi</span>
                        <span class="detail-value" style="color:var(--r-600);">Rp
                            {{ number_format($schedule->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Stok Kursi</span>
                        <span class="detail-value">{{ $schedule->stock }} tersedia</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary & form -->
        <div class="sum-card">
            <div class="sum-head">
                <h3>Rincian Pembayaran</h3>
            </div>
            <div class="sum-body">
                <form action="{{ route('booking.store', $schedule->id) }}" method="POST" id="booking-form">
                    @csrf

                    <div class="seat-section">
                        <label class="seat-label" for="input_kursi">Jumlah Penumpang</label>
                        <div class="seat-row">
                            <button type="button" class="seat-btn" id="btn-minus">−</button>
                            <input type="number" name="total_seats" id="input_kursi" class="seat-input" min="1"
                                max="{{ $schedule->stock }}" value="{{ old('total_seats', 1) }}" required>
                            <button type="button" class="seat-btn" id="btn-plus">+</button>
                        </div>
                        <span class="seat-hint">Maks. {{ $schedule->stock }} kursi per pemesanan</span>
                    </div>

                    <div class="total-box">
                        <div class="total-label">Total Tagihan</div>
                        <div class="total-amount" id="total_harga">Rp {{ number_format($schedule->price, 0, ',', '.') }}
                        </div>
                    </div>

                    <button type="submit" class="submit-btn">
                        Pesan Sekarang
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12" />
                            <polyline points="12 5 19 12 12 19" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('input_kursi');
            const display = document.getElementById('total_harga');
            const btnMin = document.getElementById('btn-minus');
            const btnPls = document.getElementById('btn-plus');
            const maxSeat = {{ $schedule->stock }};
            const price = {{ $schedule->price }};

            function clamp(v) { return Math.max(1, Math.min(maxSeat, v)); }

            function refresh() {
                const q = clamp(parseInt(input.value) || 1);
                input.value = q;
                display.textContent = 'Rp ' + (q * price).toLocaleString('id-ID');
            }

            btnMin.addEventListener('click', () => { input.value = clamp((parseInt(input.value) || 1) - 1); refresh(); });
            btnPls.addEventListener('click', () => { input.value = clamp((parseInt(input.value) || 1) + 1); refresh(); });
            input.addEventListener('input', refresh);
            refresh();
        });
    </script>
@endsection
