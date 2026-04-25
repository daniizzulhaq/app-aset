<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    protected $fillable = ['nama_lokasi', 'keterangan'];

    public function asets()
    {
        return $this->hasMany(Aset::class);
    }
}