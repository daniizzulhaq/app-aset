<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'aset_id', 'user_id', 'nama_peminjam',
        'tanggal_pinjam', 'tanggal_kembali',
        'status', 'keterangan',
    ];

    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}