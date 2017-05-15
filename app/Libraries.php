<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Libraries extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'lon', 'lat', 'regeneration'
    ];
}