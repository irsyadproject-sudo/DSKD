<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PemeriksaanTindakan extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan_tindakan';

    protected $fillable = [
        'pemeriksaan_id',
        'tindakan_id',
        'qty',
        'harga',
        'subtotal',
        'keterangan',
    ];

    public function pemeriksaan(): BelongsTo
    {
        return $this->belongsTo(Pemeriksaan::class);
    }

    public function tindakan(): BelongsTo
    {
        return $this->belongsTo(Tindakan::class);
    }
}
