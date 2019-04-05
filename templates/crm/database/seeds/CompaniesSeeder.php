<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CompaniesSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
    	foreach (range(1,10000) as $index) {
            $company = $faker->company;
	        DB::table('companies')->insert([
                'name' => $company,
                'common_name' => $company,
                'company_type_id' => rand(1, 4),
                'street_prefix_id' => 1,
                'city' => $faker->city,
                'street' => $faker->streetAddress,
	            'email' => $faker->email,
	        ]);
	    }
    }
}
