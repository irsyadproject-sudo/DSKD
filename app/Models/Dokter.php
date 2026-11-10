<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\UsesEncryptedRouteKey;

class Dokter extends Model
{
    use HasFactory, UsesEncryptedRouteKey;

    protected $table = 'dokter';

    protected $fillable = [
        'user_id',
        'nama',
        'no_sip',
        'spesialisasi',
        'no_hp',
        'email',
        'tarif_konsultasi',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jadwalDokter(): HasMany
    {
        return $this->hasMany(JadwalDokter::class);
    }

    public function pemeriksaan(): HasMany
    {
        return $this->hasMany(Pemeriksaan::class);
    }
}
