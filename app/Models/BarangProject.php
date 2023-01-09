<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BarangProject extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project');
    }
}


