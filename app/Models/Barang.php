<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Eloquent
{
    use HasFactory;
    use SoftDeletes;
    protected $connection = 'mongodb';
    protected $collection = 'barangs';
    protected $guarded = ['id'];
    
    public function totalBarang()
    {
      
        $total = BarangProject::where('id_barang', $this->id)->sum('stock');
        
        return $total;
    }
}
