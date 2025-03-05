<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\City;
use App\Models\IdentificationType;
use App\Models\Status;

class SportsClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $identification_types = IdentificationType::all();
        $status = Status::where('status_type_id', 1)->get();
        $citys = City::all();

        $faker = Faker::create();
        foreach( range(1,100) as $index ) {

            $identification_type = $identification_types->random();
            $state = $status->random();
            $city = $citys->random();

            DB::table('sports_club')->insert([
                'identification_type_id' => $identification_type->id,
                'identification' => $faker->ssn,
                'name_' => $faker->company,
                'city_id' => $city->id,
                'address' => $faker->address,
                'zipcode' => $faker->postcode('CO'),
                'phone1' => $faker->e164PhoneNumber,
                'phone2' => $faker->e164PhoneNumber,
                'email' => $faker->unique()->safeEmail,
                'founding_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'register_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'status_id' => $state->id,
            ]);
        }
    }
}
