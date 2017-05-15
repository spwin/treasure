<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserClues extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'clue_id'
    ];

    public function getClue(){
        $this->hasOne('App/StrangerClues', 'id', 'clue_id');
    }

    public function getUser(){
        $this->hasOne('App/User', 'id', 'user_id');
    }
}
