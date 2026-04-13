<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Schedule;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BookingTransactionFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_creates_customer_role(): void
    {
        $response = $this->post('/register', [
            'name' => 'Customer Baru',
            'email' => 'customer@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/login');

        $this->assertDatabaseHas('users', [
            'email' => 'customer@example.com',
            'role' => User::ROLE_CUSTOMER,
        ]);
    }

    public function test_customer_booking_payment_and_admin_approval_flow(): void
    {
        Storage::fake('public');

        $customer = User::factory()->create([
            'role' => User::ROLE_CUSTOMER,
        ]);

        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        $schedule = Schedule::create([
            'plane_name' => 'Garuda Test',
            'origin' => 'Jakarta',
            'destination' => 'Bali',
            'departure' => now()->addDays(2),
            'price' => 1500000,
            'stock' => 10,
        ]);

        $bookingResponse = $this
            ->actingAs($customer)
            ->post(route('booking.store', $schedule->id), [
                'total_seats' => 2,
            ]);

        $booking = Booking::with('transaction')->firstOrFail();

        $bookingResponse->assertRedirect(route('booking.ticket', $booking));
        $this->assertEquals(Booking::STATUS_WAITING_PAYMENT, $booking->status);
        $this->assertEquals(Transaction::STATUS_UNPAID, $booking->transaction->payment_status);
        $this->assertDatabaseHas('schedules', [
            'id' => $schedule->id,
            'stock' => 8,
        ]);

        $paymentResponse = $this
            ->actingAs($customer)
            ->post(route('payment.store', $booking), [
                'payer_name' => 'Customer Baru',
                'payer_email' => 'customer@example.com',
                'payer_phone' => '081234567890',
                'payment_method' => 'Transfer Bank BCA',
                'payer_account_number' => '1234567890123',
                'notes' => 'Transfer via mobile banking',
                'payment_proof' => UploadedFile::fake()->image('proof.jpg'),
            ]);

        $booking->refresh();
        $booking->load('transaction');

        $paymentResponse->assertRedirect(route('booking.ticket', $booking));
        $this->assertEquals(Booking::STATUS_WAITING_APPROVAL, $booking->status);
        $this->assertEquals(Transaction::STATUS_WAITING_APPROVAL, $booking->transaction->payment_status);
        $this->assertNotNull($booking->transaction->paid_at);
        $this->assertSame('1234567890123', $booking->transaction->payer_account_number);
        $this->assertNotNull($booking->transaction->payment_proof_path);
        Storage::disk('public')->assertExists($booking->transaction->payment_proof_path);

        $approveResponse = $this
            ->actingAs($admin)
            ->post(route('admin.bookings.approve', $booking));

        $booking->refresh();
        $booking->load('transaction');

        $approveResponse->assertRedirect();
        $this->assertEquals(Booking::STATUS_COMPLETED, $booking->status);
        $this->assertEquals(Transaction::STATUS_APPROVED, $booking->transaction->payment_status);
        $this->assertNotNull($booking->transaction->approved_at);
    }

    public function test_expired_schedule_cannot_be_booked(): void
    {
        $customer = User::factory()->create([
            'role' => User::ROLE_CUSTOMER,
        ]);

        $schedule = Schedule::create([
            'plane_name' => 'Garuda Lama',
            'origin' => 'Jakarta',
            'destination' => 'Surabaya',
            'departure' => now()->subHour(),
            'price' => 900000,
            'stock' => 5,
        ]);

        $response = $this
            ->actingAs($customer)
            ->post(route('booking.store', $schedule->id), [
                'total_seats' => 1,
            ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseMissing('bookings', [
            'schedule_id' => $schedule->id,
        ]);
    }
}
