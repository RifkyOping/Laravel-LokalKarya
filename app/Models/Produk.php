<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = [
        'user_id',
        'nama_produk',
        'gambar_produk',
        'harga',
        'deskripsi',
        'kategori',
        'status',
        'status_verifikasi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
