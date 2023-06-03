<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Kendaraan extends Model
{
    use SoftDeletes;
    protected $collection = 'kendaraan';

    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];

}
