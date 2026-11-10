<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\UsesEncryptedRouteKey;

class Resep extends Model
{
    use HasFactory, UsesEncryptedRouteKey;

    protected $table = 'resep';

    protected $fillable = [
        'pemeriksaan_id',
        'no_resep',
        'tanggal',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function pemeriksaan(): BelongsTo
    {
        return $this->belongsTo(Pemeriksaan::class);
    }

    public function detailResep(): HasMany
    {
        return $this->hasMany(DetailResep::class);
    }
}
