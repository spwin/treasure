<?php

namespace App\Console\Commands;

use App\Configuration;
use App\Resources;
use App\Towers;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Robot2Command extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'robot2:start';

    public $lat_meter = 0.000012346; //1m
    public $lon_meter = 0.000009091; //1m
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fills the area in resources using towers';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $configuration = Configuration::all();
        $config = [];
        foreach($configuration as $c){
            $config[$c->key] = $c->value;
        }

        $towers = Towers::where(['checked' => 0])->inRandomOrder()->take(100)->get();
        if(count($towers) == 0){
            DB::table('towers')->update(['checked' => 0]);
        } else {
            $resources = Resources::where(['status' => 0])->get();
            foreach($towers as $tower){
                // CHECK RESOURCES
                $radius_lat = ($config['density_resources']*$this->lat_meter);
                $radius_lon = ($config['density_resources']*$this->lon_meter);
                $min_lat = $tower->lat - $radius_lat;
                $max_lat = $tower->lat + $radius_lat;
                $min_lon = $tower->lon - $radius_lon;
                $max_lon = $tower->lon + $radius_lon;
                $add_resource = true;
                foreach($resources as $resource) {
                    if (
                        $resource->lat >= $min_lat &&
                        $resource->lat <= $max_lat &&
                        $resource->lon >= $min_lon &&
                        $resource->lon <= $max_lon
                    ) {
                        $add_resource = false;
                        break;
                    }
                }
                if($add_resource){
                    $mln = 1000000;
                    $diff_lat = $max_lat - $min_lat;
                    $diff_lon = $max_lon - $min_lon;
                    $rand_lat = rand(0, round($diff_lat*$mln))/$mln;
                    $rand_lon = rand(0, round($diff_lon*$mln))/$mln;
                    $new_location_lat = $min_lat + $rand_lat;
                    $new_location_lon = $min_lon + $rand_lon;
                    $new_resource = new Resources();

                    // TODO: mind the percentage of the resources types

                    $new_resource->fill([
                        'type' => 'gold',
                        'quantity' => 1,
                        'lat' => $new_location_lat,
                        'lon' => $new_location_lon,
                        'name' => 'Resource',
                        'description' => 'Resource description',
                        'status' => 0
                    ]);
                    $new_resource->save();
                }

            }
        }
    }
}
