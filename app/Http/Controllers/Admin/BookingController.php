<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Transaction;

class BookingController extends Controller
{
    // Approve booking
    public function approve(Booking $booking)
    {
        $booking->loadMissing('transaction');

        if (! $booking->transaction) {
            return back()->with('error', 'Transaksi untuk booking ini belum tersedia.');
        }

        if (! $booking->transaction->isAwaitingApproval()) {
            return back()->with('error', 'Transaksi ini belum dikonfirmasi oleh customer.');
        }

        if (! $booking->transaction->hasPaymentProof()) {
            return back()->with('error', 'Bukti pembayaran belum tersedia.');
        }

        $booking->transaction->update([
            'payment_status' => Transaction::STATUS_APPROVED,
            'paid_at' => $booking->transaction->paid_at ?? now(),
            'approved_at' => now(),
        ]);

        $booking->update(['status' => Booking::STATUS_COMPLETED]);

        return back()->with('success', 'Transaksi berhasil disetujui.');
    }
}
