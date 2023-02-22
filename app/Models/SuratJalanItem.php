<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SuratJalanItem extends Eloquent
{
    use HasFactory;
    protected $guarded = ['id'];

    public function barang(){
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}
