<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Points extends Model
{
    protected $fillable = [
        'coordinates_id', 'status', 'user_id', 'reward_id', 'paid'
    ];

    public function getUser(){
        return $this->hasOne('App\Users', 'id', 'user_id');
    }

    public function getReward(){
        return $this->hasOne('App\Rewards', 'id', 'reward_id');
    }

    public function getCoordinates(){
        return $this->hasOne('App\Coordinates', 'id', 'coordinates_id');
    }
}