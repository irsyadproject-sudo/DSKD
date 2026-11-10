<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPembayaran extends Model
{
    use HasFactory;

    protected $table = 'detail_pembayaran';

    protected $fillable = [
        'pembayaran_id',
        'tipe',
        'referensi_id',
        'nama_item',
        'keterangan',
        'qty',
        'harga',
        'subtotal',
    ];

    public function pembayaran(): BelongsTo
    {
        return $this->belongsTo(Pembayaran::class);
    }
}
