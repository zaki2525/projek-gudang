<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];

    public function namaBarang()
    {
        return $this->belongsTo(NamaBarang::class, 'id_nama_barang');        
    }
    
    public function totalBarang()
    {
      
        $total = BarangProject::where('id_barang', $this->id)->sum('stock');
        
        return $total;
    }
}
