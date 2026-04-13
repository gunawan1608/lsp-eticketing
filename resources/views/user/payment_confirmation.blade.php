@extends('layouts.app')

@section('title', 'Konfirmasi Pembayaran - E-Ticket Pro')

@section('styles')
<style>
    .pay-layout {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 1.5rem;
        align-items: start;
    }

    .pay-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .pay-topbar h2 {
        font-size: 1.375rem;
        font-weight: 800;
        color: var(--n-900);
        letter-spacing: -0.03em;
        margin: 0;
    }

    /* Card */
    .pcard {
        background: var(--surface);
        border: 1.5px solid var(--border);
        border-radius: 1.125rem;
        overflow: hidden;
    }

    .pcard-head {
        padding: 1rem 1.5rem;
        border-bottom: 1.5px solid var(--n-100);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .pcard-head h3 { font-size: 1rem; font-weight: 800; color: var(--n-900); margin: 0; letter-spacing: -0.02em; }

    .pcard-body { padding: 1.5rem; }

    /* ── Bank / payment method CARD PICKER ── */
    .bank-section-label {
        font-size: 0.8125rem;
        font-weight: 600;
        color: var(--n-700);
        margin-bottom: 0.75rem;
        display: block;
    }

    .bank-picker {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.625rem;
        margin-bottom: 1.5rem;
    }

    .bank-option {
        position: relative;
        cursor: pointer;
    }

    .bank-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .bank-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        padding: 0.875rem 0.625rem;
        border: 1.5px solid var(--border);
        border-radius: 0.875rem;
        background: var(--n-50);
        cursor: pointer;
        transition: border-color 0.18s, background 0.18s, box-shadow 0.18s;
        text-align: center;
        user-select: none;
    }

    .bank-card:hover {
        border-color: var(--r-300, #fda4af);
        background: var(--r-50);
    }

    .bank-option input[type="radio"]:checked + .bank-card {
        border-color: var(--r-500);
        background: var(--r-50);
        box-shadow: 0 0 0 3px rgba(244,63,94,.12);
    }

    .bank-card__icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .bank-card__icon--brand {
        width: 56px;
        background: #fff;
        border: 1px solid var(--n-200);
        overflow: hidden;
        padding: 0.25rem;
    }

    .bank-card__icon img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
        border-radius: inherit;
    }

    .bank-card__icon--bca     { background: #005fcc; color: #fff; }
    .bank-card__icon--mandiri { background: #003580; color: #f7b900; }
    .bank-card__icon--qris    { background: #1a1a2e; color: #fff; }

    .bank-card__name {
        font-size: 0.78rem;
        font-weight: 700;
        color: var(--n-800);
    }

    .bank-card__num {
        font-size: 0.68rem;
        color: var(--n-400);
        font-weight: 500;
        line-height: 1.4;
    }

    .bank-card__check {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        width: 16px; height: 16px;
        border-radius: 50%;
        background: var(--r-600);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transform: scale(0.6);
        transition: opacity 0.2s, transform 0.2s;
    }

    .bank-option input[type="radio"]:checked ~ .bank-card__check {
        opacity: 1;
        transform: scale(1);
    }

    /* Fix: the check mark needs to be sibling of input, inside bank-option */

    /* Form */
    .form-stack { display: flex; flex-direction: column; gap: 1rem; }

    .field { display: flex; flex-direction: column; gap: 0.375rem; }

    .field label {
        font-size: 0.8125rem;
        font-weight: 600;
        color: var(--n-700);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .field label span { font-size: 0.72rem; color: var(--n-400); font-weight: 400; }

    .field input,
    .field textarea {
        padding: 0.75rem 0.875rem;
        background: var(--n-50);
        border: 1.5px solid var(--border);
        border-radius: 0.625rem;
        font-size: 0.9375rem;
        color: var(--n-900);
        font-family: inherit;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        -webkit-appearance: none;
    }

    .field input::placeholder, .field textarea::placeholder { color: var(--n-300); }

    .field input:focus, .field textarea:focus {
        border-color: var(--r-400);
        background: var(--surface);
        box-shadow: 0 0 0 3px rgba(244,63,94,.10);
    }

    .field textarea { resize: vertical; min-height: 80px; }

    /* File drop */
    .file-drop {
        position: relative;
        padding: 1.25rem;
        background: var(--n-50);
        border: 2px dashed var(--border);
        border-radius: 0.75rem;
        text-align: center;
        transition: border-color 0.2s, background 0.2s;
        cursor: pointer;
    }

    .file-drop:hover { border-color: var(--r-300, #fda4af); background: var(--r-50); }

    .file-drop input[type="file"] {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .file-drop-icon { color: var(--n-300); margin-bottom: 0.5rem; }
    .file-drop-text { font-size: 0.875rem; font-weight: 600; color: var(--n-500); }
    .file-drop-hint { font-size: 0.72rem; color: var(--n-400); margin-top: 0.2rem; }

    .proof-preview-wrap { margin-top: 0.875rem; display: none; }
    .proof-preview-wrap.visible { display: block; }
    .proof-preview-wrap img { width: 100%; max-height: 200px; object-fit: cover; border-radius: 0.625rem; border: 1.5px solid var(--border); }

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
        margin-top: 0.5rem;
    }

    .submit-btn:hover { background: var(--r-700); transform: translateY(-1px); box-shadow: 0 7px 22px rgba(225,29,72,.30); }

    /* Info pills */
    .info-pill {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        padding: 0.875rem 1rem;
        border-radius: 0.625rem;
        font-size: 0.8125rem;
        font-weight: 500;
        line-height: 1.5;
        margin-bottom: 1.25rem;
    }

    .info-pill--yellow { background: var(--warning-bg); color: var(--warning-text); }
    .info-pill--green  { background: var(--success-bg); color: var(--success-text); }
    .info-pill svg { flex-shrink: 0; margin-top: 0.1rem; }

    /* Summary card */
    .sum-card {
        background: var(--surface);
        border: 1.5px solid var(--border);
        border-radius: 1.125rem;
        overflow: hidden;
        position: sticky;
        top: 80px;
    }

    .sum-head { padding: 1rem 1.5rem; border-bottom: 1.5px solid var(--n-100); }
    .sum-head h3 { font-size: 1rem; font-weight: 800; color: var(--n-900); margin: 0; letter-spacing: -0.02em; }

    .sum-body { padding: 1.125rem 1.5rem; display: flex; flex-direction: column; gap: 0; }

    .sum-row {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        gap: 0.75rem;
        padding: 0.5rem 0;
        border-bottom: 1px solid var(--n-100);
    }
    .sum-row:last-child { border-bottom: none; }

    .sum-key { font-size: 0.8125rem; color: var(--n-500); font-weight: 500; white-space: nowrap; }
    .sum-val { font-size: 0.875rem; font-weight: 700; color: var(--n-900); text-align: right; }
    .sum-val--red { color: var(--r-600); font-size: 1.0625rem; }

    /* CTA */
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
    .cta-btn--primary { background: var(--r-600); color: #fff; box-shadow: var(--shadow-red); }
    .cta-btn--primary:hover { background: var(--r-700); transform: translateY(-1px); }

    .approved-proof img { width: 100%; border-radius: 0.75rem; border: 1.5px solid var(--border); margin-bottom: 1rem; }
    .view-proof-link {
        display: inline-flex; align-items: center; gap: 0.375rem;
        font-size: 0.875rem; font-weight: 600; color: var(--r-600); text-decoration: none; margin-bottom: 1.25rem;
    }
    .view-proof-link:hover { text-decoration: underline; }

    @media (max-width: 900px) {
        .pay-layout { grid-template-columns: 1fr; }
        .sum-card { position: static; }
    }

    @media (max-width: 560px) {
        .bank-picker { grid-template-columns: repeat(3, 1fr); }
    }
</style>
@endsection

@section('content')
@php($transaction = $booking->transaction)

<div class="pay-topbar">
    <h2>Konfirmasi Pembayaran</h2>
    <a href="{{ route('booking.ticket', $booking) }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Kembali ke Tiket
    </a>
</div>

<div class="pay-layout">

    {{-- Left: form --}}
    <div class="pcard">
        <div class="pcard-head">
            <h3>Data Pembayaran</h3>
        </div>
        <div class="pcard-body">

            @if($transaction?->isApproved())
                <div class="info-pill info-pill--green">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Pembayaran telah disetujui admin
                </div>
                @if($transaction->payment_proof_url)
                    <div class="approved-proof">
                        <img src="{{ $transaction->payment_proof_url }}" alt="Bukti pembayaran">
                        <a href="{{ $transaction->payment_proof_url }}" target="_blank" class="view-proof-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                            Lihat bukti pembayaran
                        </a>
                    </div>
                @endif
                <a href="{{ route('booking.ticket', $booking) }}" class="cta-btn cta-btn--primary">Kembali ke Tiket</a>

            @else
                @if($transaction?->isAwaitingApproval())
                    <div class="info-pill info-pill--yellow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        Terkirim {{ $transaction->paid_at?->format('d M Y, H:i') }} · Menunggu verifikasi admin
                    </div>
                @endif

                <form action="{{ route('payment.store', $booking) }}" method="POST" enctype="multipart/form-data" id="payment-form">
                    @csrf
                    <div class="form-stack">

                        {{-- Bank / payment picker --}}
                        <div>
                            <span class="bank-section-label">Metode & Tujuan Pembayaran</span>
                            <input type="hidden" name="payment_method" id="payment_method_hidden" value="{{ old('payment_method', $transaction?->payment_method) }}">
                            <div class="bank-picker">

                                <label class="bank-option">
                                    <input type="radio" name="_payment_pick" value="Transfer Bank BCA"
                                        {{ old('payment_method', $transaction?->payment_method) === 'Transfer Bank BCA' ? 'checked' : '' }}>
                                    <div class="bank-card">
                                        <div class="bank-card__icon bank-card__icon--brand">
                                            <img src="{{ asset('assets/bca.jpg') }}" alt="Logo BCA">
                                        </div>
                                        <span class="bank-card__name">BCA</span>
                                        <span class="bank-card__num">1234-5678-90<br>a.n. E-Ticket Pro</span>
                                    </div>
                                    <div class="bank-card__check">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                    </div>
                                </label>

                                <label class="bank-option">
                                    <input type="radio" name="_payment_pick" value="Transfer Bank Mandiri"
                                        {{ old('payment_method', $transaction?->payment_method) === 'Transfer Bank Mandiri' ? 'checked' : '' }}>
                                    <div class="bank-card">
                                        <div class="bank-card__icon bank-card__icon--brand">
                                            <img src="{{ asset('assets/mandiri.png') }}" alt="Logo Bank Mandiri">
                                        </div>
                                        <span class="bank-card__name">Mandiri</span>
                                        <span class="bank-card__num">9876-5432-10<br>a.n. E-Ticket Pro</span>
                                    </div>
                                    <div class="bank-card__check">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                    </div>
                                </label>

                                <label class="bank-option">
                                    <input type="radio" name="_payment_pick" value="QRIS / E-Wallet"
                                        {{ old('payment_method', $transaction?->payment_method) === 'QRIS / E-Wallet' ? 'checked' : '' }}>
                                    <div class="bank-card">
                                        <div class="bank-card__icon bank-card__icon--qris">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="8" height="8" rx="1"/><rect x="14" y="2" width="8" height="8" rx="1"/><rect x="2" y="14" width="8" height="8" rx="1"/><path d="M14 14h2v2h-2zM18 14h2v2h-2zM14 18h2v2h-2zM18 18h2v2h-2z"/></svg>
                                        </div>
                                        <span class="bank-card__name">QRIS</span>
                                        <span class="bank-card__num">Scan & Pay<br>E-Wallet</span>
                                    </div>
                                    <div class="bank-card__check">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                    </div>
                                </label>

                            </div>
                        </div>

                        <div class="field">
                            <label for="payer_name">Nama Lengkap</label>
                            <input type="text" id="payer_name" name="payer_name"
                                value="{{ old('payer_name', $transaction?->payer_name ?? $booking->user->name) }}"
                                placeholder="Nama sesuai pengirim" required>
                        </div>

                        <div class="field">
                            <label for="payer_email">Email</label>
                            <input type="email" id="payer_email" name="payer_email"
                                value="{{ old('payer_email', $transaction?->payer_email ?? $booking->user->email) }}"
                                placeholder="nama@email.com" required>
                        </div>

                        <div class="field">
                            <label for="payer_phone">No. HP</label>
                            <input type="text" id="payer_phone" name="payer_phone"
                                value="{{ old('payer_phone', $transaction?->payer_phone) }}"
                                placeholder="08xxxxxxxxxx" required>
                        </div>

                        <div class="field d-none" id="account-number-group">
                            <label for="payer_account_number">Nomor Rekening Pengirim</label>
                            <input type="text" id="payer_account_number" name="payer_account_number"
                                value="{{ old('payer_account_number', $transaction?->payer_account_number) }}"
                                placeholder="Nomor rekening Anda">
                        </div>

                        <div class="field">
                            <label for="payment_proof">Bukti Pembayaran</label>
                            <div class="file-drop" id="file-drop-zone">
                                <input type="file" id="payment_proof" name="payment_proof"
                                    accept=".jpg,.jpeg,.png,.webp,image/*" required>
                                <div class="file-drop-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                </div>
                                <div class="file-drop-text" id="file-drop-label">Klik untuk pilih gambar</div>
                                <div class="file-drop-hint">JPG, PNG, WEBP · Maks 2 MB</div>
                            </div>
                            <div class="proof-preview-wrap" id="proof-preview-wrap">
                                <img src="" alt="Preview" id="proof-preview">
                            </div>
                        </div>

                        <div class="field">
                            <label for="notes">Catatan <span>Opsional</span></label>
                            <textarea id="notes" name="notes" placeholder="Catatan tambahan">{{ old('notes', $transaction?->notes) }}</textarea>
                        </div>

                        <button type="button" class="submit-btn" id="payment-submit">
                            {{ $transaction?->isAwaitingApproval() ? 'Perbarui Konfirmasi' : 'Kirim Konfirmasi Pembayaran' }}
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </button>
                    </div>
                </form>
            @endif

        </div>
    </div>

    {{-- Right: summary --}}
    <div class="sum-card">
        <div class="sum-head"><h3>Ringkasan Order</h3></div>
        <div class="sum-body">
            <div class="sum-row">
                <span class="sum-key">Tiket</span>
                <span class="sum-val">{{ $booking->ticket_number }}</span>
            </div>
            @if($transaction?->transaction_code)
            <div class="sum-row">
                <span class="sum-key">Transaksi</span>
                <span class="sum-val">{{ $transaction->transaction_code }}</span>
            </div>
            @endif
            <div class="sum-row">
                <span class="sum-key">Penerbangan</span>
                <span class="sum-val">{{ $booking->schedule->plane_name }}</span>
            </div>
            <div class="sum-row">
                <span class="sum-key">Rute</span>
                <span class="sum-val">{{ strtoupper(substr($booking->schedule->origin,0,3)) }} → {{ strtoupper(substr($booking->schedule->destination,0,3)) }}</span>
            </div>
            <div class="sum-row">
                <span class="sum-key">Berangkat</span>
                <span class="sum-val">{{ $booking->schedule->departure->format('d M Y, H:i') }}</span>
            </div>
            <div class="sum-row">
                <span class="sum-key">Kursi</span>
                <span class="sum-val">{{ $booking->total_seats }} kursi</span>
            </div>
            <div class="sum-row">
                <span class="sum-key">Status</span>
                <span class="sum-val">{{ $transaction?->payment_status ?? 'Belum ada transaksi' }}</span>
            </div>
            <div class="sum-row">
                <span class="sum-key">Total Bayar</span>
                <span class="sum-val sum-val--red">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

</div>

<audio id="payment-sound" src="{{ asset('sound_effect/ksjsbwuil-cash-register-1-513922.mp3') }}" preload="auto"></audio>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form        = document.getElementById('payment-form');
    const submitBtn   = document.getElementById('payment-submit');
    const proofInput  = document.getElementById('payment_proof');
    const previewWrap = document.getElementById('proof-preview-wrap');
    const preview     = document.getElementById('proof-preview');
    const fileLabel   = document.getElementById('file-drop-label');
    const accGroup    = document.getElementById('account-number-group');
    const accInput    = document.getElementById('payer_account_number');
    const methodHid   = document.getElementById('payment_method_hidden');
    const radios      = document.querySelectorAll('input[name="_payment_pick"]');
    const sound       = document.getElementById('payment-sound');

    // Sync hidden input + show/hide account field
    function syncMethod(val) {
        methodHid.value = val;
        const needsAcc = val.startsWith('Transfer Bank');
        accGroup.classList.toggle('d-none', !needsAcc);
        accInput.required = needsAcc;
        if (!needsAcc) accInput.value = '';
    }

    radios.forEach(r => {
        r.addEventListener('change', () => syncMethod(r.value));
    });

    // Init on load
    const checked = document.querySelector('input[name="_payment_pick"]:checked');
    if (checked) syncMethod(checked.value);

    // File preview
    if (proofInput && preview) {
        proofInput.addEventListener('change', function () {
            const [file] = this.files;
            if (!file) return;
            preview.src = URL.createObjectURL(file);
            previewWrap.classList.add('visible');
            fileLabel.textContent = file.name;
        });
    }

    // Submit
    if (form && submitBtn) {
        submitBtn.addEventListener('click', function () {
            if (!form.reportValidity()) return;
            if (!methodHid.value) {
                alert('Pilih metode pembayaran terlebih dahulu.');
                return;
            }
            if (sound) { sound.currentTime = 0; sound.play().catch(() => {}); }
            setTimeout(() => form.requestSubmit(), 450);
        });
    }
});
</script>
@endsection
