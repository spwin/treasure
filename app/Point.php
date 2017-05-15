<?php

namespace App;

class Point
{
    public $lon = 0;
    public $lat = 0;
    public $type = 'resource';
    public $status = 0;

    public function __construct($lat, $lon, $type, $status){
        $this->lat = $lat;
        $this->lon= $lon;
        $this->type = $type;
        $this->status = $status;
    }
}
