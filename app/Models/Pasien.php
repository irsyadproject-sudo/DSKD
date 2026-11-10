<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Traits\UsesEncryptedRouteKey;

class Pasien extends Model
{
    use HasFactory, UsesEncryptedRouteKey;

    protected $table = 'pasien';

    protected $fillable = [
        'user_id',
        'no_rm',
        'nama',
        'nik',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'golongan_darah',
        'status',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pendaftaran(): HasMany
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function pemeriksaan(): HasMany
    {
        return $this->hasMany(Pemeriksaan::class);
    }

    /**
     * Auto-generate No. Rekam Medis dengan format RM-YYYY-XXXXX
     * berdasarkan nomor urut maksimal yang sudah ada.
     */
    public static function buatNoRm(): string
    {
        $tahun = now()->format('Y');
        $last = Pasien::where('no_rm', 'like', "RM-{$tahun}-%")->max('no_rm');

        $urutan = $last ? ((int) Str::afterLast($last, '-') + 1) : 1;

        return 'RM-' . $tahun . '-' . Str::padLeft($urutan, 5, '0');
    }
}
