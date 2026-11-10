<?php

namespace App\Traits;

use Illuminate\Support\Facades\Crypt;

/**
 * Sembunyikan ID asli di URL dengan mengenkripsi route key.
 * URL seperti /pasien/{token} tidak bisa ditebak dengan menaikkan angka.
 */
trait UsesEncryptedRouteKey
{
    /**
     * Route key yang dienkripsi untuk dipakai saat membuat URL.
     */
    public function getRouteKey(): string
    {
        return Crypt::encryptString((string) $this->getKey());
    }

    /**
     * Pecahkan route key terenkripsi lalu ambil model sesuai ID asli.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        try {
            $id = (int) Crypt::decryptString((string) $value);
        } catch (\Throwable $e) {
            return null;
        }

        return $this->where($this->getKeyName(), $id)->first();
    }
}