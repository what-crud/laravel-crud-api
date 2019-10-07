<?php

use Illuminate\Database\Seeder;
use App\Models\Admin\User;

class InitSeeder extends Seeder
{
    public function run()
    {

        DB::table('user_types')
        ->insert([
            [
                'name' => 'Guest',
                'read' => true,
                'insert' => false,
                'update' => false,
                'delete' => false,
                'admin' => false,
                'active' => true,
            ],
            [
                'name' => 'User',
                'read' => true,
                'insert' => true,
                'update' => true,
                'delete' => true,
                'admin' => false,
                'active' => true,
            ],
            [
                'name' => 'Admin',
                'read' => true,
                'insert' => true,
                'update' => true,
                'delete' => true,
                'admin' => true,
                'active' => true,
            ]
        ]);

        DB::table('users')
        ->insert([
            [
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('1234'),
                'user_type_id' => 3
            ]
        ]);

        DB::table('permissions')
        ->insert([
            [
                'name' => 'CRM',
                'code' => 'CRM',
                'path' => 'crm'
            ],
            [
                'name' => 'administracja',
                'code' => 'ADMIN',
                'path' => 'admin'
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
