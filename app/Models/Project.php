<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Project extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'projects';
    protected $guarded = ['id'];
}
