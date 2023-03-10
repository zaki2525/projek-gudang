<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NamaBarang extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "nama_barangs";
    protected $guarded = ['id'];
}
