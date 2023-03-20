<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratJalan extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];
    
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang')->withDefault(['unit' => '']);
    }


    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project')->withDefault(['nama' => 'null']);
    }
}
