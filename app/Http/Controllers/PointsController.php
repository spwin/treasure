<?php

namespace App\Http\Controllers;

use App\Coordinates;
use App\Points;
use App\Rewards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PointsController extends Controller
{
    public function index(){
        $points = Points::with('getCoordinates')->orderBy('id', 'DESC')->get();
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
        if($request->get('lat') && $request->get('lng') && $request->get('paid')){
            $lat = $request->get('lat');
            $lng = $request->get('lng');
            $paid = $request->get('paid');
            for($i = 0; $i < count($lat); $i++){
                $coordinates = new Coordinates();
                $coordinates->fill([
                    'lat' => $lat[$i],
                    'lon' => $lng[$i]
                ]);
                $coordinates->save();

                $point = new Points();
                $point->fill([
                    'coordinates_id' => $coordinates->id,
                    'status' => 0,
                    'paid' => $paid[$i]
                ]);

                if($request->get('reward') && $request->get('rewardType') && $request->get('rewardAmount')){
                    $reward = $request->get('reward');
                    $rewardType = $request->get('rewardType');
                    $rewardAmount = $request->get('rewardAmount');

                    if($reward[$i]) {
                        $newReward = new Rewards();
                        $newReward->fill([
                            'type' => $rewardType[$i],
                            'amount' => $rewardAmount[$i] ? $rewardAmount[$i] : 0
                        ]);
                        $newReward->save();
                        $point->fill([
                            'reward_id' => $newReward->id
                        ]);
                    }
                }

                $point->save();
            }
            Session::flash('flash_notification.general.message', 'New Point was created successfully!');
            Session::flash('flash_notification.general.level', 'success');
        } else {
            Session::flash('flash_notification.general.message', 'There point were not saved');
            Session::flash('flash_notification.general.level', 'warning');
        }
        return redirect()->action('PointsController@index');
    }

    public function delete(){
        DB::table('points')->delete();
        Session::flash('flash_notification.general.message', 'All points deleted');
        Session::flash('flash_notification.general.level', 'success');
        return redirect()->action('PointsController@index');
    }
}
