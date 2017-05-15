<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Robot1Queue extends Model
{
    protected $table = 'robot1_queue';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lon', 'lat', 'user_id'
    ];
}
