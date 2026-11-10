<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\UsesEncryptedRouteKey;

class Tindakan extends Model
{
    use HasFactory, UsesEncryptedRouteKey;

    protected $table = 'tindakan';

    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'tarif',
        'status',
    ];

    public function pemeriksaanTindakan(): HasMany
    {
        return $this->hasMany(PemeriksaanTindakan::class);
    }
}
