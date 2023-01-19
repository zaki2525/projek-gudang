<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];
    
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }


    public function dariproject()
    {
        return $this->belongsTo(Project::class, 'dari')->withDefault('nama', 'null');
    }

    public function keproject()
    {
        return $this->belongsTo(Project::class, 'ke')->withDefault('nama', 'null');
    }
}
