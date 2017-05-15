<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resources extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'type', 'found_date', 'quantity', 'lon', 'lat', 'name', 'description', 'status'
    ];

    public function getUser(){
        return $this->hasOne('App/User', 'id', 'user_id');
    }
}