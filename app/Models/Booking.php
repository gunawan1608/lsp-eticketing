<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    public const STATUS_WAITING_PAYMENT = 'Menunggu Pembayaran';
    public const STATUS_WAITING_APPROVAL = 'Menunggu Persetujuan';
    public const STATUS_COMPLETED = 'Selesai';

    protected $table = 'bookings';

    protected $fillable = [
        'user_id',
        'schedule_id',
        'total_seats',
        'total_price',
        'status'
    ];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class);
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_COMPLETED => 'badge-success',
            self::STATUS_WAITING_PAYMENT, self::STATUS_WAITING_APPROVAL => 'badge-warning',
            default => 'badge-danger',
        };
    }

    public function getTicketNumberAttribute(): string
    {
        return 'ETK-' . str_pad((string) $this->id, 5, '0', STR_PAD_LEFT);
    }
}
