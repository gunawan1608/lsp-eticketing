@extends('layouts.app')

@section('title', 'Tiket Pemesanan - E-Ticket Pro')

@section('styles')
    <style>
        .ticket-layout {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 1.5rem;
            align-items: start;
        }

        .tkt-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .tkt-topbar h2 {
            font-size: 1.375rem;
            font-weight: 800;
            color: var(--n-900);
            letter-spacing: -0.03em;
            margin: 0;
        }

        /* Ticket card */
        .tkt-card {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 1.25rem;
            overflow: hidden;
        }

        .tkt-top {
            padding: 1.5rem;
            background: linear-gradient(135deg, #fff1f2 0%, #fafafa 100%);
            border-bottom: 1.5px dashed var(--n-200);
            position: relative;
        }

        .tkt-top::before,
        .tkt-top::after {
            content: '';
            position: absolute;
            bottom: -12px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: var(--n-100);
            border: 1.5px solid var(--n-200);
            z-index: 2;
        }

        .tkt-top::before {
            left: -11px;
        }

        .tkt-top::after {
            right: -11px;
        }

        .tkt-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.25rem;
            flex-wrap: wrap;
        }

        .tkt-num-label {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--n-400);
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .tkt-num {
            font-size: 1.375rem;
            font-weight: 900;
            color: var(--n-900);
            letter-spacing: -0.02em;
        }

        .tkt-badges {
            display: flex;
            gap: 0.375rem;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        /* Route */
        .route-disp {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .rd-code {
            font-size: 2.5rem;
            font-weight: 900;
            color: var(--r-600);
            letter-spacing: -0.04em;
            line-height: 1;
        }

        .rd-city {
            font-size: 0.8125rem;
            color: var(--n-500);
            margin-top: 0.2rem;
        }

        .rd-right {
            text-align: right;
        }

        .rd-mid {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.375rem;
        }

        .rd-mid-line {
            width: 100%;
            height: 1.5px;
            background: repeating-linear-gradient(90deg, var(--n-300) 0, var(--n-300) 5px, transparent 5px, transparent 10px);
        }

        .rd-mid svg {
            color: var(--r-400);
        }

        /* Meta grid */
        .tkt-body {
            padding: 1.5rem;
        }

        .meta-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.875rem;
        }

        .meta-item {
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
            padding: 0.875rem 1rem;
            background: var(--n-50);
            border-radius: 0.75rem;
            border: 1px solid var(--n-100);
        }

        .meta-label {
            font-size: 0.72rem;
            color: var(--n-400);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .meta-value {
            font-size: 0.9375rem;
            font-weight: 700;
            color: var(--n-900);
        }

        /* Badges */
        .tb {
            display: inline-flex;
            align-items: center;
            padding: 0.28rem 0.65rem;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .tb--red {
            background: var(--r-50);
            color: var(--r-600);
            border: 1px solid var(--r-200);
        }

        .tb--green {
            background: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .tb--yellow {
            background: var(--warning-bg);
            color: var(--warning-text);
            border: 1px solid var(--warning-border);
        }

        .tb--gray {
            background: var(--n-100);
            color: var(--n-500);
            border: 1px solid var(--n-200);
        }

        .tb--blue {
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }

        /* Status sidebar */
        .status-card {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 1.25rem;
            overflow: hidden;
            position: sticky;
            top: 80px;
        }

        .sc-head {
            padding: 1rem 1.5rem;
            border-bottom: 1.5px solid var(--n-100);
        }

        .sc-head h3 {
            font-size: 1rem;
            font-weight: 800;
            color: var(--n-900);
            margin: 0;
            letter-spacing: -0.02em;
        }

        .sc-body {
            padding: 1.25rem 1.5rem;
        }

        /* Steps */
        .steps {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .step {
            display: flex;
            align-items: flex-start;
            gap: 0.875rem;
            padding: 0.75rem 0;
            position: relative;
        }

        .step:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 13px;
            top: 36px;
            bottom: 0;
            width: 1.5px;
            background: var(--n-200);
        }

        .step-dot {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            border: 1.5px solid var(--n-200);
            background: var(--n-50);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
            z-index: 1;
        }

        .step.done .step-dot {
            background: var(--r-600);
            border-color: var(--r-600);
        }

        .step.done .step-dot::after {
            content: '';
            width: 8px;
            height: 5px;
            border-left: 2px solid #fff;
            border-bottom: 2px solid #fff;
            transform: rotate(-45deg) translate(1px, -1px);
        }

        .step.active .step-dot {
            background: #fff;
            border: 2px solid var(--r-500);
            box-shadow: 0 0 0 3px rgba(244, 63, 94, .12);
        }

        .step.active .step-dot::after {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--r-500);
        }

        .step-text {
            padding-top: 0.2rem;
        }

        .step-title {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--n-900);
        }

        .step-title.muted {
            color: var(--n-400);
            font-weight: 600;
        }

        /* CTA */
        .sc-cta {
            padding: 0 1.5rem 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .cta-btn {
            width: 100%;
            padding: 0.875rem;
            border-radius: 0.75rem;
            font-size: 0.9375rem;
            font-weight: 700;
            font-family: inherit;
            border: none;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.18s;
        }

        .cta-btn--primary {
            background: var(--r-600);
            color: #fff;
            box-shadow: var(--shadow-red);
        }

        .cta-btn--primary:hover {
            background: var(--r-700);
            transform: translateY(-1px);
        }

        .cta-btn--ghost {
            background: var(--n-50);
            color: var(--n-600);
            border: 1.5px solid var(--border);
        }

        .cta-btn--ghost:hover {
            border-color: var(--r-300, #fda4af);
            color: var(--r-600);
        }

        .info-pill {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            border-radius: 0.625rem;
            font-size: 0.8125rem;
            font-weight: 500;
            line-height: 1.5;
        }

        .info-pill--yellow {
            background: var(--warning-bg);
            color: var(--warning-text);
        }

        .info-pill--green {
            background: var(--success-bg);
            color: var(--success-text);
        }

        .info-pill svg {
            flex-shrink: 0;
            margin-top: 0.1rem;
        }

        @media (max-width: 900px) {
            .ticket-layout {
                grid-template-columns: 1fr;
            }

            .status-card {
                position: static;
            }
        }

        @media (max-width: 600px) {
            .meta-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .rd-code {
                font-size: 2rem;
            }
        }

        @media (max-width: 420px) {
            .meta-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
@php($transaction = $booking->transaction)

<div class="tkt-topbar">
    <h2>Tiket Pemesanan</h2>
    <a href="{{ route('booking.history') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12" />
            <polyline points="12 19 5 12 12 5" />
        </svg>
        Riwayat
    </a>
</div>

<div class="ticket-layout">

    <div class="tkt-card">
        <div class="tkt-top">
            <div class="tkt-header">
                <div>
                    <div class="tkt-num-label">Nomor Tiket</div>
                    <div class="tkt-num">{{ $booking->ticket_number }}</div>
                </div>
                <div class="tkt-badges">
                    <span class="tb {{ $booking->status_badge_class }}">{{ $booking->status }}</span>
                    @if($transaction)
                        <span
                            class="tb {{ $transaction->payment_status_badge_class }}">{{ $transaction->payment_status }}</span>
                    @endif
                    @if($booking->schedule->isExpired())
                        <span class="tb tb--gray">Jadwal Lewat</span>
                    @endif
                </div>
            </div>

            <div class="route-disp">
                <div>
                    <div class="rd-code">{{ strtoupper(substr($booking->schedule->origin, 0, 3)) }}</div>
                    <div class="rd-city">{{ $booking->schedule->origin }}</div>
                </div>
                <div class="rd-mid">
                    <div class="rd-mid-line"></div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.2-1.1.5l-1 2c-.1.3-.1.6.1.8l6.8 5.6-2.5 2.5-4.2-1.3c-.3-.1-.6 0-.8.2l-1 1c-.3.3-.3.7 0 .9l3.5 1.8 1.8 3.5c.2.3.6.3.9 0l1-1c.2-.2.3-.5.2-.8L6.4 17l2.5-2.5 5.6 6.8c.2.2.5.2.8.1l2-1c.3-.2.6-.6.5-1.1z" />
                    </svg>
                    <div class="rd-mid-line"></div>
                </div>
                <div class="rd-right">
                    <div class="rd-code">{{ strtoupper(substr($booking->schedule->destination, 0, 3)) }}</div>
                    <div class="rd-city">{{ $booking->schedule->destination }}</div>
                </div>
            </div>
        </div>

        <div class="tkt-body">
            <div class="meta-grid">
                <div class="meta-item">
                    <span class="meta-label">Penumpang</span>
                    <span class="meta-value">{{ $booking->user->name }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Pesawat</span>
                    <span class="meta-value">{{ $booking->schedule->plane_name }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Keberangkatan</span>
                    <span class="meta-value">{{ $booking->schedule->departure->format('d M Y, H:i') }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Jumlah Kursi</span>
                    <span class="meta-value">{{ $booking->total_seats }} kursi</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Total Tagihan</span>
                    <span class="meta-value" style="color:var(--r-600);">Rp
                        {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Waktu Order</span>
                    <span class="meta-value">{{ $booking->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Status sidebar -->
    <div class="status-card">
        <div class="sc-head">
            <h3>Status Pemesanan</h3>
        </div>
        <div class="sc-body">
            <div class="steps">
                <div class="step done">
                    <div class="step-dot"></div>
                    <div class="step-text">
                        <div class="step-title">Order dibuat</div>
                    </div>
                </div>
                <div class="step {{ $transaction?->isUnpaid() ? 'active' : ($transaction ? 'done' : '') }}">
                    <div class="step-dot"></div>
                    <div class="step-text">
                        <div class="step-title {{ !$transaction ? 'muted' : '' }}">Menunggu pembayaran</div>
                    </div>
                </div>
                <div
                    class="step {{ $transaction?->isAwaitingApproval() ? 'active' : ($transaction?->isApproved() ? 'done' : '') }}">
                    <div class="step-dot"></div>
                    <div class="step-text">
                        <div class="step-title {{ !$transaction || $transaction->isUnpaid() ? 'muted' : '' }}">
                            Verifikasi admin</div>
                    </div>
                </div>
                <div class="step {{ $transaction?->isApproved() ? 'done' : '' }}">
                    <div class="step-dot"></div>
                    <div class="step-text">
                        <div class="step-title {{ !$transaction?->isApproved() ? 'muted' : '' }}">Selesai</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sc-cta">
            @if($transaction?->isUnpaid())
                <a href="{{ route('payment.create', $booking) }}" class="cta-btn cta-btn--primary">
                    Konfirmasi Pembayaran
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12" />
                        <polyline points="12 5 19 12 12 19" />
                    </svg>
                </a>
            @elseif($transaction?->isAwaitingApproval())
                <div class="info-pill info-pill--yellow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                    Menunggu verifikasi admin
                </div>
                <a href="{{ route('payment.create', $booking) }}" class="cta-btn cta-btn--ghost">Lihat Pembayaran</a>
            @elseif($transaction?->isApproved())
                <div class="info-pill info-pill--green">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                    Disetujui {{ $transaction->approved_at?->format('d M Y') }}
                </div>
                <a href="{{ route('booking.history') }}" class="cta-btn cta-btn--ghost">Kembali ke Riwayat</a>
            @endif
        </div>
    </div>

</div>
@endsection
