<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    public function create(Booking $booking)
    {
        $this->authorizeBookingOwner($booking);

        $booking->loadMissing(['schedule', 'transaction', 'user']);

        return view('user.payment_confirmation', compact('booking'));
    }

    public function store(Request $request, Booking $booking)
    {
        $this->authorizeBookingOwner($booking);

        $booking->loadMissing(['transaction', 'schedule']);

        $transaction = $booking->transaction;

        abort_unless($transaction, 404);

        if ($transaction->isApproved()) {
            return redirect()
                ->route('booking.ticket', $booking)
                ->with('success', 'Transaksi ini sudah disetujui admin.');
        }

        $validated = $request->validate([
            'payer_name' => ['required', 'string', 'max:255'],
            'payer_email' => ['required', 'email', 'max:255'],
            'payer_phone' => ['required', 'string', 'max:30'],
            'payment_method' => ['required', 'string', 'max:100'],
            'payer_account_number' => [
                Rule::requiredIf(fn () => str_starts_with((string) $request->input('payment_method'), 'Transfer Bank')),
                'nullable',
                'string',
                'max:50',
            ],
            'notes' => ['nullable', 'string', 'max:1000'],
            'payment_proof' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($transaction->hasPaymentProof()) {
            Storage::disk('public')->delete($transaction->payment_proof_path);
        }

        $paymentProofPath = $request->file('payment_proof')->store('payment-proofs', 'public');

        $transaction->update([
            'payer_name' => $validated['payer_name'],
            'payer_email' => $validated['payer_email'],
            'payer_phone' => $validated['payer_phone'],
            'payment_method' => $validated['payment_method'],
            'payer_account_number' => $validated['payer_account_number'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'payment_proof_path' => $paymentProofPath,
            'payment_proof_original_name' => $request->file('payment_proof')->getClientOriginalName(),
            'payment_status' => Transaction::STATUS_WAITING_APPROVAL,
            'paid_at' => now(),
        ]);

        $booking->update([
            'status' => Booking::STATUS_WAITING_APPROVAL,
        ]);

        return redirect()
            ->route('booking.ticket', $booking)
            ->with('success', 'Konfirmasi pembayaran berhasil dikirim. Menunggu approval admin.');
    }

    private function authorizeBookingOwner(Booking $booking): void
    {
        abort_unless($booking->user_id === Auth::id(), 403);
    }
}
