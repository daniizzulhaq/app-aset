<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    protected $fillable = [
        'kode_aset', 'nama_aset', 'kategori_id',
        'lokasi_id', 'tanggal_beli', 'nilai_aset',
        'status', 'keterangan',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}