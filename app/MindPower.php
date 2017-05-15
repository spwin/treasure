<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MindPower extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'base', 'current', 'max', 'regeneration_base', 'regeneration_current'
    ];

    public function getUser(){
        return $this->hasOne('App/User', 'id', 'user_id');
    }
}
