<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

/**
 * Model User
 * Merepresentasikan seluruh pengguna sistem (Admin/Petugas, Dokter, Pasien).
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relasi: User dimiliki oleh satu Role.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relasi: User (pasien) memiliki satu data profil Pasien.
     */
    public function pasien(): HasOne
    {
        return $this->hasOne(Pasien::class);
    }

    /**
     * Relasi: User (dokter) memiliki satu data profil Dokter.
     */
    public function dokter(): HasOne
    {
        return $this->hasOne(Dokter::class);
    }

    /**
     * URL absolut foto profil, atau null bila belum ada / file hilang.
     */
    protected function avatarUrl(): Attribute
    {
        return Attribute::get(function (): ?string {
            if (! $this->avatar || ! Storage::disk('public')->exists($this->avatar)) {
                return null;
            }

            return Storage::disk('public')->url($this->avatar);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Role
    |--------------------------------------------------------------------------
    */

    public function hasRole(string $roleName): bool
    {
        return $this->role?->name === $roleName;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isDokter(): bool
    {
        return $this->hasRole('dokter');
    }

    public function isPasien(): bool
    {
        return $this->hasRole('pasien');
    }

    public function roleLabel(): string
    {
        return $this->role?->display_name ?? '-';
    }
}
