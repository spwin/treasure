<?php


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigurationSeeder extends Seeder
{
    public function run(){
        DB::table('configuration')->delete();
        $configuration = array(
            ['key' => 'density_resources', 'value' => '100', 'default' => '100'],
            ['key' => 'density_crystal', 'value' => '10000', 'default' => '10000'],
            ['key' => 'density_crystal_parts', 'value' => '1000', 'default' => '1000'],
            ['key' => 'density_library', 'value' => '5000', 'default' => '5000'],
            ['key' => 'density_strangers', 'value' => '100000', 'default' => '100000'],
            ['key' => 'density_global', 'value' => '10', 'default' => '10'],
            ['key' => 'density_manuscript', 'value' => '100000', 'default' => '100000'],
            ['key' => 'radius_collect_point', 'value' => '15', 'default' => '15'],
            ['key' => 'radius_library', 'value' => '50', 'default' => '50'],
            ['key' => 'radius_stranger', 'value' => '20', 'default' => '20'],
            ['key' => 'stranger_movement_speed', 'value' => '3', 'default' => '3'],
            ['key' => 'radius_manuscript', 'value' => '50', 'default' => '50'],
            ['key' => 'radius_laboratory', 'value' => '50', 'default' => '50'],
            ['key' => 'percent_resource_lead', 'value' => '20', 'default' => '20'],
            ['key' => 'percent_resource_tin', 'value' => '15', 'default' => '15'],
            ['key' => 'percent_resource_silver', 'value' => '10', 'default' => '10'],
            ['key' => 'percent_resource_gold', 'value' => '5', 'default' => '5'],
            ['key' => 'percent_resource_mercury', 'value' => '15', 'default' => '15'],
            ['key' => 'percent_resource_iron', 'value' => '25', 'default' => '25'],
            ['key' => 'percent_resource_sulfur', 'value' => '10', 'default' => '10'],
        );
        DB::table('configuration')->insert($configuration);
    }
}