<?php

namespace App\Http\Controllers;

use App\Coordinates;
use App\Points;
use App\Resources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiPointsController extends Controller
{
    public function getPoints(Request $request){
        $lat = $request->get('lat', 0);
        $lon = $request->get('lon', 0);

        if($user = Auth::guard('api')->user()){
            $user->lat = $lat;
            $user->lon = $lon;
            $user->save();
        }

        // TODO: get only nearest points

        $resources = Resources::where(['status' => 0])->get();
        $data = array();
        foreach($resources as $resource){
            $data[] = [
                'id' => $resource->id,
                'lat' => $resource->lat,
                'lon' => $resource->lon,
                'type' => $resource->type,
                'quantity' => $resource->type,
                'name' => $resource->type,
                'description' => $resource->type,
            ];
        }

        $return = array(
            'current_location' => [
                'lat' => $lat,
                'lon' => $lon
            ],
            'resources' => $data
        );

        return response()->json($return);
    }

    public function gatheredResource(Request $request){
        $id = $request->get('id');
        if($user = $request->user()){
            $resource = Resources::find($id);
            if($resource) {
                $resource->user_id = $user->id;
                $resource->status = 1;
                $resource->save();
            }
        }
        return $this->getPoints($request);
    }

    /*public function removePoint(Request $request){
        $id = $request->get('id');
        $point = Points::find($id);
        if($user = $request->user()){
            $point->user_id = $user->id;
            $point->status = 1;
            $point->save();
        } else {
            $point->delete();
        }
        return $this->getPoints($request);
    }*/
}
