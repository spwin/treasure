<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDiary extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'recipe_id', 'status'
    ];

    public function getRecipe(){
        $this->hasOne('App/Recipes', 'id', 'recipe_id');
    }

    public function getUser(){
        $this->hasOne('App/User', 'id', 'user_id');
    }
}