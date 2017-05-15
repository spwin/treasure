<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StrangerClues extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content', 'status'
    ];

    public function getUserClues(){
        return $this->hasMany('App/UserClues', 'clue_id', 'id');
    }
}
