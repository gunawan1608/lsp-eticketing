@extends('layouts.app')

@section('title', 'Dasbor Admin - E-Ticket Pro')

@section('styles')
    <style>
        /* Penyesuaian kartu statistik */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-bottom: 1.75rem;
        }

        .scard {
            background: var(--white);
            border: 1.5px solid var(--stone-3);
            border-radius: var(--r-xl);
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            transition: border-color .15s, box-shadow .15s;
        }

        .scard:hover {
            border-color: var(--stone-4);
            box-shadow: var(--shadow-sm);
        }

        .scard-icon {
            width: 42px;
            height: 42px;
            border-radius: var(--r-md);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .scard-icon svg {
            width: 18px;
            height: 18px;
        }

        .scard-icon--blue {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .scard-icon--amber {
            background: #fef3c7;
            color: #d97706;
        }

        .scard-icon--green {
            background: #dcfce7;
            color: #16a34a;
        }

        .scard-info {
            min-width: 0;
        }

        .scard-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--ink-5);
            text-transform: uppercase;
            letter-spacing: .06em;
            margin-bottom: 6px;
        }

        .scard-value {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.05em;
            line-height: 1;
            color: var(--ink);
        }

        /* Judul bagian di dalam kartu */
        .section-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        .section-label-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--red);
            flex-shrink: 0;
        }

        /* Efek sorot baris tabel */
        .table tbody tr {
            transition: background .1s;
        }

        /* Tombol aksi */
        .btn-edit {
            padding: 5px 12px;
            font-size: 12px;
            border-radius: var(--r-sm);
            background: var(--info-bg);
            border: 1.5px solid var(--info-border);
            color: var(--info);
            font-weight: 600;
            cursor: pointer;
            transition: background .15s;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-edit:hover {
            background: #dbeafe;
        }

        .btn-del {
            padding: 5px 12px;
            font-size: 12px;
            border-radius: var(--r-sm);
            background: var(--danger-bg);
            border: 1.5px solid var(--danger-border);
            color: var(--danger);
            font-weight: 600;
            cursor: pointer;
            transition: background .15s;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-del:hover {
            background: var(--r-100);
        }

        .btn-approve {
            padding: 5px 12px;
            font-size: 12px;
            border-radius: var(--r-sm);
            background: var(--r-600);
            border: 1.5px solid var(--r-600);
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            font-family: inherit;
        }

        .btn-approve:hover {
            background: var(--r-700);
        }

        /* Lencana status di tabel */
        .chip {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
            border: 1.5px solid transparent;
        }

        .chip-green {
            background: #f0fdf4;
            color: #16a34a;
            border-color: #bbf7d0;
        }

        .chip-amber {
            background: #fffbeb;
            color: #b45309;
            border-color: #fde68a;
        }

        .chip-red {
            background: var(--r-50);
            color: var(--r-600);
            border-color: var(--r-200);
        }

        .chip-blue {
            background: #eff6ff;
            color: #1d4ed8;
            border-color: #bfdbfe;
        }

        .chip-gray {
            background: #f4f4f5;
            color: #71717a;
            border-color: #e4e4e7;
        }

        /* Penyesuaian paginator */
        .pg-wrap {
            padding: .875rem 1.25rem;
            border-top: 1px solid var(--stone-3);
            display: flex;
            justify-content: flex-end;
        }

        /* Bilah pencarian */
        .stbar {
            padding: .75rem 1.25rem;
            border-bottom: 1px solid var(--stone-3);
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .stbar-input {
            max-width: 280px;
            height: 34px;
            padding: 0 10px;
            font-size: 13px;
            font-family: inherit;
            background: var(--stone-1);
            color: var(--ink);
            border: 1.5px solid var(--stone-3);
            border-radius: var(--r-md);
            transition: border-color .15s, box-shadow .15s;
            outline: none;
        }

        .stbar-input:focus {
            border-color: var(--red-soft);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, .10);
            background: var(--white);
        }

        .stbar-input::placeholder {
            color: var(--ink-5);
        }

        .stbar .btn {
            height: 34px;
            padding: 0 14px;
        }

        .proof-btn {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 8px;
            border-radius: var(--r-sm);
            font-size: 11px;
            font-weight: 600;
            color: var(--info);
            background: var(--info-bg);
            border: 1.5px solid var(--info-border);
            transition: background .15s;
            cursor: pointer;
            font-family: inherit;
        }

        .proof-btn:hover {
            background: #dbeafe;
        }

        /* Modal styling */
        .proof-modal {
            display: none; 
            position: fixed; 
            z-index: 9999; 
            left: 0; 
            top: 0; 
            width: 100%; 
            height: 100%; 
            background-color: rgba(0,0,0,0.6); 
            backdrop-filter: blur(4px);
            align-items: center; 
            justify-content: center;
            padding: 20px;
        }

        .proof-modal-content {
            background: var(--white); 
            padding: 24px; 
            border-radius: var(--r-lg); 
            max-width: 500px; 
            width: 100%;
            text-align: center; 
            position: relative;
            box-shadow: var(--shadow-lg);
            animation: modalFadeIn 0.2s ease-out;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(10px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .proof-modal-close {
            position: absolute; 
            top: 12px; 
            right: 16px; 
            cursor: pointer; 
            font-size: 24px; 
            line-height: 1;
            font-weight: bold;
            color: var(--ink-5);
            transition: color 0.15s;
        }
        
        .proof-modal-close:hover {
            color: var(--danger);
        }

        .proof-modal-img {
            max-width: 100%; 
            max-height: 60vh; 
            display: block; 
            margin: 0 auto 20px;
            border-radius: var(--r-md);
            border: 1px solid var(--stone-3);
        }

        @media (max-width: 900px) {
            .stats-row {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 560px) {
            .stats-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')

{{-- Kepala halaman --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Panel Admin</h1>
        <p class="page-subtitle">Kelola jadwal penerbangan dan transaksi pelanggan</p>
    </div>
    <a href="{{ url('/admin/schedules/create') }}" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="5" x2="12" y2="19" />
            <line x1="5" y1="12" x2="19" y2="12" />
        </svg>
        Tambah Jadwal
    </a>
</div>

{{-- Stats --}}
<div class="stats-row">
    <div class="scard">
        <div class="scard-icon scard-icon--blue">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path
                    d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.2-1.1.5l-1 2c-.1.3-.1.6.1.8l6.8 5.6-2.5 2.5-4.2-1.3c-.3-.1-.6 0-.8.2l-1 1c-.3.3-.3.7 0 .9l3.5 1.8 1.8 3.5c.2.3.6.3.9 0l1-1c.2-.2.3-.5.2-.8L6.4 17l2.5-2.5 5.6 6.8c.2.2.5.2.8.1l2-1c.3-.2.6-.6.5-1.1z" />
            </svg>
        </div>
        <div class="scard-info">
            <div class="scard-label">Jadwal Aktif</div>
            <div class="scard-value">{{ $activeSchedulesCount }}</div>
        </div>
    </div>
    <div class="scard">
        <div class="scard-icon scard-icon--amber">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10" />
                <polyline points="12 6 12 12 16 14" />
            </svg>
        </div>
        <div class="scard-info">
            <div class="scard-label">Menunggu Persetujuan</div>
            <div class="scard-value">{{ $pendingApprovals }}</div>
        </div>
    </div>
    <div class="scard">
        <div class="scard-icon scard-icon--green">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 11l3 3L22 4" />
                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
            </svg>
        </div>
        <div class="scard-info">
            <div class="scard-label">Transaksi Selesai</div>
            <div class="scard-value">{{ $completedTransactions }}</div>
        </div>
    </div>
</div>

{{-- Tabel jadwal --}}
<div class="card">
    <div class="card-header">
        <div class="section-label">
            <span class="section-label-dot"></span>
            Jadwal Penerbangan
        </div>
    </div>

    <div class="stbar">
        <form action="{{ route('dashboard') }}" method="GET" style="display:flex;gap:.5rem;align-items:center;">
            <input type="hidden" name="schedule_page" value="1">
            @if(filled($transactionSearch ?? ''))
                <input type="hidden" name="transaction_search" value="{{ $transactionSearch }}">
            @endif
            <input type="text" name="schedule_search" value="{{ $scheduleSearch ?? '' }}" class="stbar-input"
                placeholder="Cari pesawat, rute…">
            <button type="submit" class="btn btn-primary">Cari</button>
            @if(filled($scheduleSearch ?? ''))
                <a href="{{ route('dashboard', array_filter(['transaction_search' => $transactionSearch ?? null])) }}"
                    class="btn btn-secondary">Atur Ulang</a>
            @endif
        </form>
    </div>

    @if($schedules->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.2-1.1.5l-1 2c-.1.3-.1.6.1.8l6.8 5.6-2.5 2.5-4.2-1.3c-.3-.1-.6 0-.8.2l-1 1c-.3.3-.3.7 0 .9l3.5 1.8 1.8 3.5c.2.3.6.3.9 0l1-1c.2-.2.3-.5.2-.8L6.4 17l2.5-2.5 5.6 6.8c.2.2.5.2.8.1l2-1c.3-.2.6-.6.5-1.1z" />
                </svg>
            </div>
            Tidak ada jadwal ditemukan.
        </div>
    @else
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Pesawat</th>
                        <th>Rute</th>
                        <th>Keberangkatan</th>
                        <th>Harga</th>
                        <th>Kursi</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($schedules as $s)
                        <tr>
                            <td><span class="td-main">{{ $s->plane_name }}</span></td>
                            <td>
                                <div class="route-pill">
                                    {{ strtoupper(substr($s->origin, 0, 3)) }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="5" y1="12" x2="19" y2="12" />
                                        <polyline points="12 5 19 12 12 19" />
                                    </svg>
                                    {{ strtoupper(substr($s->destination, 0, 3)) }}
                                </div>
                            </td>
                            <td>
                                <span class="departure-date">{{ $s->departure->format('d M Y, H:i') }}</span>
                                <span class="departure-meta">{{ $s->isExpired() ? 'Kadaluarsa' : 'Aktif' }}</span>
                            </td>
                            <td class="price-tag">Rp {{ number_format($s->price, 0, ',', '.') }}</td>
                            <td>
                                <span class="chip {{ $s->availability_badge_class }}">{{ $s->availability_label }}</span>
                            </td>
                            <td style="text-align:center;">
                                <div class="actions" style="justify-content:center;">
                                    <a href="{{ url('/admin/schedules/edit/' . $s->id) }}" class="btn-edit">Ubah</a>
                                    <a href="{{ url('/admin/schedules/delete/' . $s->id) }}" class="btn-del"
                                        onclick="return confirm('Hapus jadwal ini?')">Hapus</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pg-wrap">
            @include('partials.pagination', ['paginator' => $schedules])
        </div>
    @endif
</div>

{{-- Tabel transaksi --}}
<div class="card section-gap">
    <div class="card-header">
        <div class="section-label">
            <span class="section-label-dot"></span>
            Transaksi Pelanggan
        </div>
    </div>

    <div class="stbar">
        <form action="{{ route('dashboard') }}" method="GET" style="display:flex;gap:.5rem;align-items:center;">
            <input type="hidden" name="transaction_page" value="1">
            @if(filled($scheduleSearch ?? ''))
                <input type="hidden" name="schedule_search" value="{{ $scheduleSearch }}">
            @endif
            <input type="text" name="transaction_search" value="{{ $transactionSearch ?? '' }}" class="stbar-input"
                placeholder="Cari pelanggan, kode, status...">
            <button type="submit" class="btn btn-primary">Cari</button>
            @if(filled($transactionSearch ?? ''))
                <a href="{{ route('dashboard', array_filter(['schedule_search' => $scheduleSearch ?? null])) }}"
                    class="btn btn-secondary">Atur Ulang</a>
            @endif
        </form>
    </div>

    @if($bookings->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="5" width="20" height="14" rx="2" />
                    <line x1="2" y1="10" x2="22" y2="10" />
                </svg>
            </div>
            Belum ada transaksi dari pelanggan.
        </div>
    @else
    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Tiket</th>
                    <th>Pelanggan</th>
                    <th>Penerbangan</th>
                    <th>Pembayaran</th>
                    <th>Bukti</th>
                    <th>Status</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $b)
                @php($transaction = $b->transaction)
                <tr>
                    <td>
                        <span class="td-main"
                            style="font-family:'DM Mono',monospace;font-size:12px;">{{ $b->ticket_number }}</span>
                        <span class="td-sub">{{ $transaction?->transaction_code ?? '—' }}</span>
                    </td>
                    <td>
                        <span class="user-name">{{ $transaction?->payer_name ?? $b->user->name }}</span>
                        <span class="user-meta">{{ $transaction?->payer_email ?? $b->user->email }}</span>
                        @if($transaction?->payer_phone)
                            <span class="user-meta">{{ $transaction->payer_phone }}</span>
                        @endif
                    </td>
                    <td>
                        <span class="td-main">{{ $b->schedule->plane_name }}</span>
                        <span class="td-sub">
                            {{ strtoupper(substr($b->schedule->origin, 0, 3)) }} →
                            {{ strtoupper(substr($b->schedule->destination, 0, 3)) }}
                            · {{ $b->total_seats }} kursi
                        </span>
                    </td>
                    <td>
                        <span class="td-main">{{ $transaction?->payment_method ?? '—' }}</span>
                        @if($transaction?->payer_account_number)
                            <span class="td-sub">{{ $transaction->payer_account_number }}</span>
                        @endif
                        <span
                            class="td-sub">{{ $transaction?->paid_at?->format('d/m/Y H:i') ?? 'Belum konfirmasi' }}</span>
                    </td>
                    <td>
                        @if($transaction?->payment_proof_url)
                            <button type="button" onclick="showProofModal('{{ $transaction->payment_proof_url }}')" class="proof-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                                Lihat
                            </button>
                        @else
                            <span class="td-sub">Belum ada</span>
                        @endif
                    </td>
                    <td>
                        <div class="badge-stack">
                            <span class="chip {{ $b->status_badge_class }}">{{ $b->status }}</span>
                            @if($transaction)
                                <span
                                    class="chip {{ $transaction->payment_status_badge_class }}">{{ $transaction->payment_status }}</span>
                            @endif
                        </div>
                    </td>
                    <td style="text-align:center;">
                        @if($transaction?->isAwaitingApproval())
                            <form action="{{ route('admin.bookings.approve', $b) }}" method="POST"
                                onsubmit="return confirm('Setujui transaksi ini?');">
                                @csrf
                                <button type="submit" class="btn-approve">Setujui</button>
                            </form>
                        @elseif($transaction?->isApproved())
                            <span class="td-sub">Disetujui</span>
                        @else
                            <span class="td-sub">Menunggu</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="pg-wrap">
        @include('partials.pagination', ['paginator' => $bookings])
    </div>
    @endif
</div>

{{-- Modal Pembuktian --}}
<div id="proofModal" class="proof-modal" onclick="if(event.target === this) closeProofModal()">
    <div class="proof-modal-content">
        <span onclick="closeProofModal()" class="proof-modal-close">&times;</span>
        <h3 style="margin-top:0; margin-bottom:16px; font-size:16px; color:var(--ink);">Bukti Pembayaran</h3>
        <img id="proofImage" src="" alt="Bukti Pembayaran" class="proof-modal-img" />
        <div>
            <a id="proofDownload" href="" target="_blank" class="btn btn-primary" style="display:inline-flex; width:auto;">Buka di Tab Baru</a>
        </div>
    </div>
</div>

<script>
function showProofModal(url) {
    document.getElementById('proofImage').src = url;
    document.getElementById('proofDownload').href = url;
    document.getElementById('proofModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeProofModal() {
    document.getElementById('proofModal').style.display = 'none';
    document.body.style.overflow = '';
}
</script>

@endsection
