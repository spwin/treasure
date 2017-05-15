<?php

namespace App\Console\Commands;

use App\Robot1Queue;
use App\Towers;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Robot1Command extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'robot1:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add towers by user location';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        //@ TODO: not all but only by min max lon lat
        $web = Towers::all();

        $user_points = array(
            ['lat' => 51.477478, 'lon' => 0.009591, 'user_id' => 1],
            ['lat' => 51.477355, 'lon' => 0.012505, 'user_id' => 1],
        );

        $points = [];
        foreach($user_points as $point){
            $center_lat = round($point['lat'], 3);
            $center_lon = round($point['lon'], 3);
            $points[] = ['lat' => $center_lat-0.001, 'lon' => $center_lon-0.001, 'user_id' => $point['user_id']];
            $points[] = ['lat' => $center_lat, 'lon' => $center_lon-0.001, 'user_id' => $point['user_id']];
            $points[] = ['lat' => $center_lat+0.001, 'lon' => $center_lon-0.001, 'user_id' => $point['user_id']];
            $points[] = ['lat' => $center_lat-0.001, 'lon' => $center_lon, 'user_id' => $point['user_id']];
            $points[] = ['lat' => $center_lat, 'lon' => $center_lon, 'user_id' => $point['user_id']];
            $points[] = ['lat' => $center_lat+0.001, 'lon' => $center_lon, 'user_id' => $point['user_id']];
            $points[] = ['lat' => $center_lat-0.001, 'lon' => $center_lon+0.001, 'user_id' => $point['user_id']];
            $points[] = ['lat' => $center_lat, 'lon' => $center_lon+0.001, 'user_id' => $point['user_id']];
            $points[] = ['lat' => $center_lat+0.001, 'lon' => $center_lon+0.001, 'user_id' => $point['user_id']];
        }

        $towers = [];

        if(count($web) > 0) {
            foreach ($points as $point) {
                $exists = false;
                foreach ($web as $tower) {
                    if (abs($tower->lat-$point['lat']) < 0.0001 && abs($tower->lon-$point['lon']) < 0.0001) {
                        $exists = true;
                        break;
                    }
                }
                if (!$exists) {
                    $towers[] = ['lat' => $point['lat'], 'lon' => $point['lon'], 'checked' => 0, 'user_id' => $point['user_id']];
                }
            }
        } else {
            foreach ($points as $point) {
                $towers[] = ['lat' => $point['lat'], 'lon' => $point['lon'], 'checked' => 0, 'user_id' => $point['user_id']];
            }
        }

        foreach($towers as $tower_data){
            $tower = new Towers();
            $tower->fill($tower_data);
            $tower->save();
        }

        DB::table('robot1_queue')->delete();
    }
}
