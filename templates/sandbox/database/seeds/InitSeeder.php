<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\User;

class InitSeeder extends Seeder
{
    public function run()
    {
        $user = new User();
        $user->name = 'admin';
        $user->email = 'admin@admin.com';
        $user->password = bcrypt('1234');
        $user->save();

        DB::table('permissions')
        ->insert([
            [
                'name' => 'CRM',
                'code' => 'CRM',
            ],
            [
                'name' => 'administracja',
                'code' => 'ADMIN',
            ]
        ]);

        DB::table('user_permissions')
        ->insert([
            ['user_id' => 1,'permission_id' => 1],
            ['user_id' => 1,'permission_id' => 2]
        ]);

        DB::table('company_types')
        ->insert([
            ['name' => 'Media','code' => 'MED'],
            ['name' => 'Firmy IT','code' => 'FIT'],
            ['name' => 'Sklepy','code' => 'SKL'],
            ['name' => 'Organizacje','code' => 'ORG'],
        ]);

        DB::table('sexes')
        ->insert([
            ['name' => '-','code' => '-', 'eng_name' => '-', 'eng_code' => '-', 'priority' => '1'],
            ['name' => 'Kobieta','code' => 'K', 'eng_name' => 'Female', 'eng_code' => 'F', 'priority' => '2'],
            ['name' => 'Mężczyzna','code' => 'M', 'eng_name' => 'Male', 'eng_code' => 'M', 'priority' => '3'],
        ]);

        DB::table('street_prefixes')
        ->insert([
            ['name' => '','description' => '-'],
            ['name' => 'ul.','description' => 'Ulica'],
            ['name' => 'al.','description' => 'Aleja'],
            ['name' => 'pl.','description' => 'Plac'],
            ['name' => 'os.','description' => 'Osiedle'],
        ]);

        DB::table('languages')
        ->insert([
            ['name' => 'Polski','priority' => 1],
            ['name' => 'Angielski','priority' => 2],
        ]);
    }
}
