<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'postcode', 'city', 'address'
    ];

    public function getUser(){
        return $this->hasOne('App/User', 'id', 'user_id');
    }
}