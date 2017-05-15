<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipes extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'bonus', 'chance', 'lead', 'tin', 'silver', 'gold', 'mercury', 'iron', 'sulfur', 'manuscript'
    ];

    public function getDiaries(){
        return $this->hasMany('App/UserDiary', 'recipe_id', 'id');
    }
}