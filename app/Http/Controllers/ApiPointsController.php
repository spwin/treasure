<?php

namespace App\Http\Controllers;

use App\Coordinates;
use App\Points;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiPointsController extends Controller
{
    public function getPoints(Request $request){
        $lat = $request->get('lat', 0);
        $lon = $request->get('lon', 0);

        if($user = Auth::guard('api')->user()){
            if(!$user->getCoordinates){
                $coordinates = new Coordinates();
            } else {
                $coordinates = $user->getCoordinates()->first();
            }
            $coordinates->fill([
                'lat' => $lat,
                'lon' => $lon
            ]);
            $coordinates->save();
            $user->coordinates_id = $coordinates->id;
            $user->save();
        }

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

    public function removePoint(Request $request){
        $id = $request->get('id');
        $point = Points::find($id);
        $point->delete();

        return $this->getPoints($request);
    }
}
