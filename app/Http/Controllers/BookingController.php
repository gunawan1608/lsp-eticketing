<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Schedule;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    // Menampilkan halaman detail sebelum memesan
    public function show($id)
    {
        $schedule = Schedule::findOrFail($id);

        if ($schedule->isExpired()) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Jadwal ini sudah kadaluarsa dan tidak bisa dibooking lagi.');
        }

        if ($schedule->stock <= 0) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Kursi untuk jadwal ini sudah habis.');
        }

        return view('user.booking_detail', compact('schedule'));
    }

    // Memproses pesanan ke database
    public function store(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);

        if ($schedule->isExpired()) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Jadwal ini sudah kadaluarsa dan tidak bisa dibooking lagi.');
        }

        $validated = $request->validate([
            'total_seats' => ['required', 'integer', 'min:1', 'max:' . $schedule->stock],
        ]);

        $booking = DB::transaction(function () use ($schedule, $validated) {
            $schedule->refresh();

            if ($schedule->isExpired()) {
                throw ValidationException::withMessages([
                    'total_seats' => 'Jadwal ini sudah kadaluarsa dan tidak bisa dibooking lagi.',
                ]);
            }

            if ($validated['total_seats'] > $schedule->stock) {
                throw ValidationException::withMessages([
                    'total_seats' => 'Jumlah kursi melebihi stok yang tersedia saat ini.',
                ]);
            }

            $totalPrice = $validated['total_seats'] * $schedule->price;

            $booking = Booking::create([
                'user_id' => Auth::id(),
                'schedule_id' => $schedule->id,
                'total_seats' => $validated['total_seats'],
                'total_price' => $totalPrice,
                'status' => Booking::STATUS_WAITING_PAYMENT,
            ]);

            Transaction::create([
                'booking_id' => $booking->id,
                'transaction_code' => 'TRX-' . str_pad((string) $booking->id, 5, '0', STR_PAD_LEFT),
                'payment_status' => Transaction::STATUS_UNPAID,
            ]);

            $schedule->decrement('stock', $validated['total_seats']);

            return $booking;
        });

        return redirect()
            ->route('booking.ticket', $booking)
            ->with('success', 'Pemesanan berhasil dibuat. Silakan cek tiket lalu lanjut ke konfirmasi pembayaran.');
    }

    // Menampilkan riwayat pesanan user yang sedang login
    public function history(Request $request)
    {
        $search = trim((string) $request->input('search'));

        $orders = Booking::query()
            ->where('user_id', Auth::id())
            ->with(['schedule', 'transaction'])
            ->when($search !== '', function (Builder $query) use ($search) {
                $query->where(function (Builder $builder) use ($search) {
                    $builder
                        ->where('bookings.status', 'like', '%' . $search . '%')
                        ->orWhereHas('schedule', function (Builder $scheduleQuery) use ($search) {
                            $scheduleQuery
                                ->where('plane_name', 'like', '%' . $search . '%')
                                ->orWhere('origin', 'like', '%' . $search . '%')
                                ->orWhere('destination', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('transaction', function (Builder $transactionQuery) use ($search) {
                            $transactionQuery
                                ->where('transaction_code', 'like', '%' . $search . '%')
                                ->orWhere('payment_method', 'like', '%' . $search . '%')
                                ->orWhere('payer_name', 'like', '%' . $search . '%')
                                ->orWhere('payer_email', 'like', '%' . $search . '%');
                        });

                    if (preg_match('/(\d+)/', $search, $matches) === 1) {
                        $builder->orWhere('bookings.id', (int) $matches[1]);
                    }
                });
            })
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('user.history', compact('orders', 'search'));
    }

    public function ticket(Booking $booking)
    {
        $this->authorizeBookingOwner($booking);

        $booking->loadMissing(['schedule', 'transaction', 'user']);

        return view('user.ticket', compact('booking'));
    }

    private function authorizeBookingOwner(Booking $booking): void
    {
        abort_unless($booking->user_id === Auth::id(), 403);
    }
}
