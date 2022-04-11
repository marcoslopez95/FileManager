<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('rols')->insertGetId(
            [
                'name' => 'Admin',
                'description' => 'administrador',
                'created_id' => 1,
                'updated_id' => 1,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ]
        );
        DB::table('rols')->insertGetId(
            [
                'name' => 'Lector',
                'description' => 'solo lectura',
                'created_id' => 1,
                'updated_id' => 1,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ]
        );

        DB::table('permit_rol')->insertGetId(
            [
                'permit_id' => 2,
                'rol_id' => 2,
                'created_id' => 1,
                'updated_id' => 1,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ]
        );
        DB::table('permit_rol')->insertGetId(
            [
                'permit_id' => 6,
                'rol_id' => 2,
                'created_id' => 1,
                'updated_id' => 1,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ]
        );

        DB::table('rol_user')->insertGetId(
            [
                'user_id' => 1,
                'rol_id' => 1,
                'created_id' => 1,
                'updated_id' => 1,
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ]
        );
        for ($i = 2; $i <= 11; $i++) {
            DB::table('rol_user')->insertGetId(
                [
                    'user_id' => $i,
                    'rol_id' => 2,
                    'created_id' => 1,
                    'updated_id' => 1,
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now()
                ]
            );
        }
    }
}