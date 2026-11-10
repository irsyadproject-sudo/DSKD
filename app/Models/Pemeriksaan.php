<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\UsesEncryptedRouteKey;

class Pemeriksaan extends Model
{
    use HasFactory, UsesEncryptedRouteKey;

    protected $table = 'pemeriksaan';

    protected $fillable = [
        'antrian_id',
        'pendaftaran_id',
        'dokter_id',
        'pasien_id',
        'tanggal_periksa',
        'catatan_fisik',
        'keluhan',
        'diagnosis',
    ];

    protected $casts = [
        'tanggal_periksa' => 'date',
    ];

    public function antrian(): BelongsTo
    {
        return $this->belongsTo(Antrian::class);
    }

    public function pendaftaran(): BelongsTo
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function dokter(): BelongsTo
    {
        return $this->belongsTo(Dokter::class);
    }

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    public function pemeriksaanTindakan(): HasMany
    {
        return $this->hasMany(PemeriksaanTindakan::class);
    }

    public function resep(): HasMany
    {
        return $this->hasMany(Resep::class);
    }
}
