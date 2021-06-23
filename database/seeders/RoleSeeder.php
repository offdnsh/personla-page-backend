<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            ['name' => 'Пользоватеть', 'guard_name' => 'user'],
            ['name' => 'Модератор', 'guard_name' => 'moderator'],
        ];
        DB::table('roles')->insert($values);
    }
}
