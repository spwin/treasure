<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Towers extends Model
{
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lon', 'lat', 'checked', 'user_id'
    ];

    public function getUser(){
        $this->hasOne('App/User', 'user_id', 'id');
    }

}
