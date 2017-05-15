<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'item_id', 'worn', 'expires_at'
    ];

    public function getUser(){
        return $this->hasOne('App/User', 'id', 'user_id');
    }

    public function getItem(){
        return $this->hasOne('App/Items', 'id', 'item_id');
    }
}