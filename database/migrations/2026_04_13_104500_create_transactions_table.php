<?php

use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->unique()->constrained()->onDelete('cascade');
            $table->string('transaction_code')->unique();
            $table->string('payment_method')->nullable();
            $table->string('payer_name')->nullable();
            $table->text('notes')->nullable();
            $table->string('payment_status')->default(Transaction::STATUS_UNPAID);
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });

        $legacyBookings = DB::table('bookings')->select('id', 'status', 'created_at', 'updated_at')->get();

        if ($legacyBookings->isNotEmpty()) {
            DB::table('transactions')->insert(
                $legacyBookings->map(function (object $booking): array {
                    $status = strtolower((string) $booking->status);
                    $isApproved = in_array($status, ['lunas', 'success', 'berhasil', 'selesai'], true);

                    return [
                        'booking_id' => $booking->id,
                        'transaction_code' => 'TRX-' . str_pad((string) $booking->id, 5, '0', STR_PAD_LEFT),
                        'payment_method' => null,
                        'payer_name' => null,
                        'notes' => 'Migrated from legacy booking data.',
                        'payment_status' => $isApproved
                            ? Transaction::STATUS_APPROVED
                            : Transaction::STATUS_WAITING_APPROVAL,
                        'paid_at' => $isApproved ? $booking->updated_at : null,
                        'approved_at' => $isApproved ? $booking->updated_at : null,
                        'created_at' => $booking->created_at ?? now(),
                        'updated_at' => $booking->updated_at ?? now(),
                    ];
                })->all()
            );
        }

        DB::table('bookings')
            ->whereIn('status', ['Pending', 'pending'])
            ->update(['status' => Booking::STATUS_WAITING_APPROVAL]);

        DB::table('bookings')
            ->whereIn('status', ['Lunas', 'lunas', 'Success', 'success', 'Berhasil', 'berhasil'])
            ->update(['status' => Booking::STATUS_COMPLETED]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
