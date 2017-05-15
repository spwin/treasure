<?php

namespace App\Http\Controllers;

use App\Configuration;
use App\CrystalPieces;
use App\Crystals;
use App\Libraries;
use App\Manuscripts;
use App\Point;
use App\Resources;
use App\Robot1Queue;
use App\Strangers;
use App\Towers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{
    public function index(){
        $points = array();

        $robot1_queue = Robot1Queue::all();

        $resources = Resources::where(['status' => 0])->get();
        foreach($resources as $r){
            $points[] = new Point($r->lat, $r->lon, 'resource', $r->status);
        }

        /*$crystals = Crystals::where(['status' => 0])->get();
        foreach($crystals as $c){
            $points[] = new Point($c->lat, $c->lon, 'crystal', $c->status);
        }

        $crystal_pieces = CrystalPieces::where(['status' => 0])->get();
        foreach($crystal_pieces as $cp){
            $points[] = new Point($cp->lat, $cp->lon, 'crystal_piece', $cp->status);
        }

        $libraries = Libraries::get();
        foreach($libraries as $l){
            $points[] = new Point($l->lat, $l->lon, 'library', 0);
        }

        $manuscripts = Manuscripts::where(['status' => 0])->get();
        foreach($manuscripts as $m){
            $points[] = new Point($m->lat, $m->lon, 'manuscript', $m->status);
        }

        $strangers = Strangers::get();
        foreach($strangers as $s){
            $points[] = new Point($s->lat, $s->lon, 'stranger', 0);
        }
        */

        $users = User::where(['status' => 0])->whereNotNull('lat')->whereNotNull('lon')->get();
        foreach($users as $u){
            $points[] = new Point($u->lat, $u->lon, 'user', $u->status);
        }

        $configuration = Configuration::get();

        $towers = Towers::all();

        return view('map.index')->with([
            'configuration' => $configuration,
            'points' => $points,
            'robot1_queue' => $robot1_queue,
            'towers' => $towers
        ]);
    }

    public function update(Request $request){
        $data = $request->all();
        DB::table('configuration')->delete();
        $configuration= array();
        foreach($data as $key => $values) {
            if($key != '_token') {
                $configuration[] = [
                    'key' => $key,
                    'value' => $values['value'],
                    'default' => $values['default']
                ];
            }
        }
        DB::table('configuration')->insert($configuration);
        return redirect()->action('MapController@index');
    }
}
