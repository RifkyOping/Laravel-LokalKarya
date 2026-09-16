<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Di dalam App\Models\User.php
    public function sellerProfile()
    {
        return $this->hasOne(SellerProfile::class);
    }

    /**
     * Cek apakah profil seller sudah lengkap.
     * Field wajib: nomor_whatsapp, alamat, bidang_keahlian, deskripsi
     */
    public function isProfileComplete(): bool
    {
        $profile = $this->sellerProfile;

        if (!$profile) {
            return false;
        }

        return !empty(trim($profile->nomor_whatsapp ?? ''))
            && !empty(trim($profile->alamat ?? ''))
            && !empty(trim($profile->bidang_keahlian ?? ''))
            && !empty(trim($profile->deskripsi ?? ''));
    }
}
