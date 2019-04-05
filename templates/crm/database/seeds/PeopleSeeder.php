<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
    	foreach (range(1,3000) as $index) {
            $sex = $faker->randomElement(['male', 'female']);
	        DB::table('people')->insert([
                'firstname' => $faker->firstName($sex),
                'lastname' => $faker->lastName,
                'distinction' => $faker->suffix,
                'sex_id' => $sex == 'male' ? 2 : 3,
                'language_id' => 2,
	            'email' => $faker->email,
	            'phone' => $faker->phoneNumber,
	        ]);
	    }
    }
}
