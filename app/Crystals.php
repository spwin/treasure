<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Crystals extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'found_date', 'quantity', 'lon', 'lat', 'status'
    ];

    public function getUser(){
        return $this->hasOne('App/User', 'id', 'user_id');
    }
}