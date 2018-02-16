<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')
        ->insert([
            [
                'name' => 'CRM',
                'code' => 'CRM',
            ],
            [
                'name' => 'apteki',
                'code' => 'PHA',
            ],
            [
                'name' => 'hurtownie',
                'code' => 'WHS',
            ],
            [
                'name' => 'szpitale',
                'code' => 'HOS',
            ],
            [
                'name' => 'apteki - rozliczenia',
                'code' => 'FIN_PHA',
            ],
            [
                'name' => 'hurtownie - rozliczenia',
                'code' => 'FIN_WHS',
            ],
            [
                'name' => 'szpitale - rozliczenia',
                'code' => 'FIN_HOS',
            ],
            [
                'name' => 'administracja',
                'code' => 'ADMIN',
            ]
        ]);
    }
}
