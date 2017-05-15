<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manuscripts extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'recipe_id', 'found_date', 'quantity', 'lon', 'lat', 'status'
    ];

    public function getRecipes(){
        $this->hasMany('App/Recipes', 'id', 'recipe_id');
    }
}