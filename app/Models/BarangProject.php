<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class BarangProject extends Eloquent
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}


