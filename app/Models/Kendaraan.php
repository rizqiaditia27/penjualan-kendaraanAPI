<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Kendaraan extends Model
{
    
    protected $collection = 'kendaraan';

    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];

}
