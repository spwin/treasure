<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'premium', 'crystals', 'status', 'level', 'radius', 'lon', 'lat'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getLaboratory(){
        return $this->hasOne('App/Laboratories', 'user_id', 'id');
    }

    public function getMindPower(){
        return $this->hasOne('App/MindPower', 'user_id', 'id');
    }

    public function getInventory(){
        return $this->hasMany('App/Inventory', 'user_id', 'id');
    }

    public function getResources(){
        return $this->hasMany('App/Resources', 'user_id', 'id');
    }

    public function getCrystals(){
        return $this->hasMany('App/Crystals', 'user_id', 'id');
    }

    public function getCrystalPieces(){
        return $this->hasMany('App/CrystalPieces', 'user_id', 'id');
    }

    public function getUserAddress(){
        return $this->hasOne('App/UserAddress', 'user_id', 'id');
    }

    public function getDiary(){
        return $this->hasMany('App/UserDiary', 'user_id', 'id');
    }

    public function getClues(){
        return $this->hasMany('App/UserClues', 'user_id', 'id');
    }

    public function getTowers(){
        return $this->hasMany('App/Towers', 'user_id', 'id');
    }
}