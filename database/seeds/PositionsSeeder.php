<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PositionsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
    	foreach (range(1,2000) as $index) {
            $company = $faker->company;
	        DB::table('positions')->insert([
                'company_id' => rand(3, 370),
                'person_id' => rand(1, 3011),
                'name' => $faker->jobTitle,
                'phone' => $faker->phoneNumber,
	        ]);
	    }
    }
}
