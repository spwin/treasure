<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rewards extends Model
{
    protected $fillable = [
        'type', 'amount', 'details'
    ];

    public function getPoint(){
        return $this->hasOne('App\Points', 'reward_id', 'id');
    }

}
