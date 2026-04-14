@extends('layouts.app')

@section('title', 'Riwayat Pemesanan - E-Ticket Pro')

@section('styles')
    <style>
        .hist-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.75rem;
            flex-wrap: wrap;
        }

        .hist-title-block .hist-eyebrow {
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

        .hist-title-block .hist-eyebrow span {
            width: 5px;
            height: 5px;
            background: var(--r-500);
            border-radius: 50%;
            flex-shrink: 0;
        }

        .hist-title {
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
            max-width: 360px;
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

        /* Daftar pesanan */
        .order-list {
            display: flex;
            flex-direction: column;
            gap: 0.625rem;
        }

        .order-card {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 1rem;
            overflow: hidden;
            transition: border-color 0.18s, box-shadow 0.18s, transform 0.18s;
        }

        .order-card:hover {
            border-color: var(--r-200);
            box-shadow: 0 4px 20px rgba(225, 29, 72, .06);
            transform: translateY(-1px);
        }

        .order-main {
            padding: 1.25rem 1.5rem;
            display: grid;
            grid-template-columns: auto 1fr auto;
            gap: 1.125rem;
            align-items: center;
        }

        /* Rute */
        .or-route {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .or-code {
            font-size: 1.375rem;
            font-weight: 900;
            color: var(--n-900);
            letter-spacing: -0.04em;
            line-height: 1;
        }

        .or-arrow {
            color: var(--n-300);
            display: flex;
            align-items: center;
        }

        /* Informasi tambahan */
        .or-meta {
            min-width: 0;
        }

        .or-ticket {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--n-900);
            margin-bottom: 0.25rem;
        }

        .or-sub {
            font-size: 0.78rem;
            color: var(--n-400);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .or-sub span {
            white-space: nowrap;
        }

        /* Sisi kanan */
        .or-right {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 0.5rem;
            flex-shrink: 0;
        }

        .or-price {
            font-size: 1.0625rem;
            font-weight: 800;
            color: var(--r-600);
            letter-spacing: -0.02em;
            white-space: nowrap;
        }

        .or-badges {
            display: flex;
            gap: 0.375rem;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        /* Bagian bawah */
        .order-foot {
            padding: 0.75rem 1.5rem;
            background: var(--n-50);
            border-top: 1px solid var(--n-100);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .order-foot-info {
            font-size: 0.78rem;
            color: var(--n-400);
        }

        .order-actions {
            display: flex;
            gap: 0.5rem;
        }

        /* Lencana */
        .ob {
            display: inline-flex;
            align-items: center;
            padding: 0.22rem 0.6rem;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .ob--green {
            background: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .ob--yellow {
            background: var(--warning-bg);
            color: var(--warning-text);
            border: 1px solid var(--warning-border);
        }

        .ob--red {
            background: var(--r-50);
            color: var(--r-600);
            border: 1px solid var(--r-200);
        }

        .ob--blue {
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }

        .ob--gray {
            background: var(--n-100);
            color: var(--n-500);
            border: 1px solid var(--n-200);
        }

        /* Tombol aksi */
        .act-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.45rem 0.875rem;
            border-radius: 0.5rem;
            font-size: 0.8125rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.15s;
            font-family: inherit;
            cursor: pointer;
            border: 1.5px solid transparent;
        }

        .act-btn--primary {
            background: var(--r-600);
            color: #fff;
            box-shadow: 0 2px 8px rgba(225, 29, 72, .20);
        }

        .act-btn--primary:hover {
            background: var(--r-700);
            transform: translateY(-1px);
        }

        .act-btn--ghost {
            background: var(--surface);
            border-color: var(--border);
            color: var(--n-600);
        }

        .act-btn--ghost:hover {
            border-color: var(--r-300, #fda4af);
            color: var(--r-600);
        }

        /* Kondisi kosong */
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
            margin-bottom: 1.5rem;
        }

        @media (max-width: 640px) {
            .order-main {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }

            .or-right {
                align-items: flex-start;
            }

            .or-badges {
                justify-content: flex-start;
            }

            .hist-header {
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

<div class="hist-header">
    <div class="hist-title-block">
        <div class="hist-eyebrow"><span></span> Pemesanan Saya</div>
        <h1 class="hist-title">Riwayat Pemesanan</h1>
    </div>

    <form action="{{ route('booking.history') }}" method="GET" style="display:contents;">
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
                placeholder="Cari tiket, pesawat, atau status">
            @if(filled($search ?? ''))
                <a href="{{ route('booking.history') }}" class="reset-link">Atur Ulang</a>
            @endif
            <button type="submit" class="search-btn">Cari</button>
        </div>
    </form>
</div>

@if($orders->isEmpty())
    <div class="empty-box">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
            stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="4" width="18" height="18" rx="2" />
            <line x1="16" y1="2" x2="16" y2="6" />
            <line x1="8" y1="2" x2="8" y2="6" />
            <line x1="3" y1="10" x2="21" y2="10" />
        </svg>
        <h3>Belum ada riwayat</h3>
        <p>Pemesanan Anda akan muncul di sini</p>
        <a href="{{ route('dashboard') }}" class="act-btn act-btn--primary">Cari Penerbangan</a>
    </div>
@else
<div class="order-list">
    @foreach($orders as $item)
    @php($transaction = $item->transaction)
    <div class="order-card">
        <div class="order-main">
            <div class="or-route">
                <div class="or-code">{{ strtoupper(substr($item->schedule->origin, 0, 3)) }}</div>
                <div class="or-arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12" />
                        <polyline points="12 5 19 12 12 19" />
                    </svg>
                </div>
                <div class="or-code">{{ strtoupper(substr($item->schedule->destination, 0, 3)) }}</div>
            </div>

            <div class="or-meta">
                <div class="or-ticket">{{ $item->ticket_number }}</div>
                <div class="or-sub">
                    <span>{{ $item->schedule->plane_name }}</span>
                    <span>·</span>
                    <span>{{ $item->total_seats }} kursi</span>
                    <span>·</span>
                    <span>{{ $item->created_at->format('d M Y') }}</span>
                </div>
            </div>

            <div class="or-right">
                <div class="or-price">Rp {{ number_format($item->total_price, 0, ',', '.') }}</div>
                <div class="or-badges">
                    <span class="ob {{ $item->status_badge_class }}">{{ $item->status }}</span>
                    @if($transaction)
                        <span
                            class="ob {{ $transaction->payment_status_badge_class }}">{{ $transaction->payment_status }}</span>
                    @else
                        <span class="ob ob--gray">Belum bayar</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="order-foot">
            <span class="order-foot-info">
                {{ $item->schedule->departure->format('d M Y, H:i') }} &nbsp;·&nbsp;
                {{ $item->schedule->origin }} → {{ $item->schedule->destination }}
            </span>
            <div class="order-actions">
                <a href="{{ route('booking.ticket', $item) }}" class="act-btn act-btn--ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v2z" />
                    </svg>
                    Tiket
                </a>
                @if($transaction?->isUnpaid())
                    <a href="{{ route('payment.create', $item) }}" class="act-btn act-btn--primary">Bayar</a>
                @elseif($transaction?->isAwaitingApproval())
                    <a href="{{ route('payment.create', $item) }}" class="act-btn act-btn--ghost">Lihat Pembayaran</a>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

@include('partials.pagination', ['paginator' => $orders])
@endif

@endsection
