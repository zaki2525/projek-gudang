<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];    

    public function namaBarang()
    {
        return $this->belongsTo(NamaBarang::class, 'id_nama_barang');
    }
}
