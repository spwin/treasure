<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Laboratories extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'lon', 'lat', 'status', 'change_on'
    ];

    public function getUser(){
        return $this->hasOne('App/User', 'id', 'user_id');
    }
}