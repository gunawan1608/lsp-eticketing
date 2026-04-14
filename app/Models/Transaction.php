<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Transaction extends Model
{
    public const STATUS_UNPAID = 'Belum Dibayar';
    public const STATUS_WAITING_APPROVAL = 'Menunggu Persetujuan';
    public const STATUS_APPROVED = 'Disetujui';

    protected $table = 'transactions';

    protected $fillable = [
        'booking_id',
        'transaction_code',
        'payment_method',
        'payer_name',
        'payer_email',
        'payer_phone',
        'payer_account_number',
        'notes',
        'payment_proof_path',
        'payment_proof_original_name',
        'payment_status',
        'paid_at',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'paid_at' => 'datetime',
            'approved_at' => 'datetime',
        ];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function getPaymentMethodAttribute(?string $value): ?string
    {
        return match ($value) {
            'QRIS / E-Wallet' => 'QRIS / Dompet Digital',
            default => $value,
        };
    }

    public function getPaymentStatusBadgeClassAttribute(): string
    {
        return match ($this->payment_status) {
            self::STATUS_APPROVED => 'badge-success',
            self::STATUS_UNPAID, self::STATUS_WAITING_APPROVAL => 'badge-warning',
            default => 'badge-danger',
        };
    }

    public function isUnpaid(): bool
    {
        return $this->payment_status === self::STATUS_UNPAID;
    }

    public function isAwaitingApproval(): bool
    {
        return $this->payment_status === self::STATUS_WAITING_APPROVAL;
    }

    public function isApproved(): bool
    {
        return $this->payment_status === self::STATUS_APPROVED;
    }

    public function usesBankAccount(): bool
    {
        return str_starts_with((string) $this->payment_method, 'Transfer Bank');
    }

    public function hasPaymentProof(): bool
    {
        return filled($this->payment_proof_path);
    }

    public function getPaymentProofUrlAttribute(): ?string
    {
        if (! $this->hasPaymentProof()) {
            return null;
        }

        return asset('storage/' . $this->payment_proof_path);
    }
}
