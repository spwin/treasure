<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coordinates extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lon', 'lat'
    ];

    public function getUser(){
        return $this->hasOne('App\Users', 'coordinates_id', 'id');
    }

    public function getPoint(){
        return $this->hasOne('App\Points', 'coordinates_id', 'id');
    }
}

