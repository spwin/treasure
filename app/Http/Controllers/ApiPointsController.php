<?php

namespace App\Http\Controllers;

use App\Points;
use Illuminate\Http\Request;

class ApiPointsController extends Controller
{
    public function getPoints(Request $request){
        $lat = $request->get('lat');
        $lon = $request->get('lon');

        $points = Points::where(['status' => 0])->get();
        $data = array();
        foreach($points as $point){
            $data[] = [
                'id' => $point->id,
                'lat' => $point->getCoordinates->lat,
                'lon' => $point->getCoordinates->lon
            ];
        }

        $return = array(
            'current_location' => [
                'lat' => $lat,
                'lon' => $lon
            ],
            'points' => $data
        );

        return response()->json($return);
    }
}
