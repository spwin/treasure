<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Strangers extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lon', 'lat', 'description'
    ];
}
