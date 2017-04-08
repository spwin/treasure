<?php

namespace App\Http\Controllers;

use App\Coordinates;
use App\Points;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PointsController extends Controller
{
    public function index(){
        $points = Points::with('getCoordinates')->get();
        return view('point.list')->with([
            'points' => $points
        ]);
    }

    public function add(){
        $point = new Points();
        return view('point.add')->with([
            'point' => $point
        ]);
    }

    public function save(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'lat' => 'required|numeric',
            'lon' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $paid = 0;
        if($request->get('paid') == 1){
            $paid = 1;
        }
        $coordinates = new Coordinates();
        $coordinates->fill([
            'lat' => $request->get('lat'),
            'lon' => $request->get('lon')
        ]);
        $coordinates->save();

        $point = new Points();
        $point->fill([
            'coordinates_id' => $coordinates->id,
            'status' => 0,
            'paid' => $paid
        ]);
        $point->save();

        Session::flash('flash_notification.general.message', 'New Point was created successfully!');
        Session::flash('flash_notification.general.level', 'success');
        return redirect()->action('PointsController@index');
    }
}
