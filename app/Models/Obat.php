<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\UsesEncryptedRouteKey;

class Obat extends Model
{
    use HasFactory, UsesEncryptedRouteKey;

    protected $table = 'obat';

    protected $fillable = [
        'kode',
        'nama',
        'satuan',
        'stok',
        'stok_minimum',
        'harga',
        'tanggal_kedaluwarsa',
        'status',
    ];

    protected $casts = [
        'tanggal_kedaluwarsa' => 'date',
    ];

    public function detailResep(): HasMany
    {
        return $this->hasMany(DetailResep::class);
    }
}
