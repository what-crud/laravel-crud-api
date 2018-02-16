<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'smasny';
        $user->email = 'szczepanmasny@gmail.com';
        $user->password = bcrypt('123qwe');
        $user->save();
    }
}
