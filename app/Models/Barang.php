<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'ruangan_id',
        'jumlah',
        'kondisi',
        'keterangan',
        'foto',
    ];

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }
}
