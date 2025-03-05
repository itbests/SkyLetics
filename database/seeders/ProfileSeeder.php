<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profile')->insert(['name_' => 'SuperAdmin', 'register_date' => '2023-09-06', 'observation' => 'Perfil de usuario SuperAdministrador','status_id' => 1]);
        DB::table('profile')->insert(['name_' => 'General', 'register_date' => '2023-09-06', 'observation' => 'Perfil de usuario General','status_id' => 1,]);

        $faker = Faker::create();
        foreach( range(1,13) as $index ) {
            DB::table('profile')->insert([
                'name_' => $faker->catchPhrase,
                'register_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'observation' => $faker->catchPhrase,
                'status_id' => $faker->randomElement($array = array (0, 1)),
            ]);
        }
    }
}
