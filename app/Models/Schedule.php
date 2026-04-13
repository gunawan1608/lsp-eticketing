<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    protected $table = 'schedules';

    protected $fillable = [
        'plane_name',
        'origin',
        'destination',
        'departure',
        'price',
        'stock',
    ];

    protected function casts(): array
    {
        return [
            'departure' => 'datetime',
        ];
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        $search = trim((string) $search);

        if ($search === '') {
            return $query;
        }

        return $query->where(function (Builder $builder) use ($search) {
            $builder
                ->where('plane_name', 'like', '%' . $search . '%')
                ->orWhere('origin', 'like', '%' . $search . '%')
                ->orWhere('destination', 'like', '%' . $search . '%');
        });
    }

    public function isExpired(?CarbonInterface $reference = null): bool
    {
        $reference ??= now();

        return $this->departure?->lessThanOrEqualTo($reference) ?? false;
    }

    public function isBookable(?CarbonInterface $reference = null): bool
    {
        return ! $this->isExpired($reference) && $this->stock > 0;
    }

    public function getAvailabilityLabelAttribute(): string
    {
        if ($this->isExpired()) {
            return 'Kadaluarsa';
        }

        if ($this->stock > 10) {
            return $this->stock . ' Kursi';
        }

        if ($this->stock > 0) {
            return 'Sisa ' . $this->stock;
        }

        return 'Habis';
    }

    public function getAvailabilityBadgeClassAttribute(): string
    {
        if ($this->isExpired() || $this->stock <= 0) {
            return 'badge-danger';
        }

        return $this->stock > 10 ? 'badge-success' : 'badge-warning';
    }
}
