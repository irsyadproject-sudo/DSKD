<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\UsesEncryptedRouteKey;

class Pembayaran extends Model
{
    use HasFactory, UsesEncryptedRouteKey;

    protected $table = 'pembayaran';

    protected $fillable = [
        'pendaftaran_id',
        'no_kuitansi',
        'tanggal_bayar',
        'total_tindakan',
        'total_obat',
        'total_biaya',
        'metode_pembayaran',
        'status',
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
    ];

    public function pendaftaran(): BelongsTo
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function detailPembayaran(): HasMany
    {
        return $this->hasMany(DetailPembayaran::class);
    }
}
