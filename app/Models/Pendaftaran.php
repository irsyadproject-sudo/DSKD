<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Traits\UsesEncryptedRouteKey;

class Pendaftaran extends Model
{
    use HasFactory, UsesEncryptedRouteKey;

    protected $table = 'pendaftaran';

    protected $fillable = [
        'no_pendaftaran',
        'pasien_id',
        'jadwal_dokter_id',
        'tanggal_daftar',
        'keluhan',
        'status',
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
    ];

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    public function jadwalDokter(): BelongsTo
    {
        return $this->belongsTo(JadwalDokter::class);
    }

    public function antrian(): HasOne
    {
        return $this->hasOne(Antrian::class);
    }

    public function pembayaran(): HasOne
    {
        return $this->hasOne(Pembayaran::class);
    }
}
