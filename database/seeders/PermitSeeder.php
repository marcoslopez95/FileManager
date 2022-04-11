<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('permit')->insertGetId(
            [
                'name' => 'Crear Carpeta',
                'description' => '.',
                'created_id' => 1,
                'updated_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Actualizar Carpeta',
                'description' => '.',
                'created_id' => 1,
                'updated_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Eliminar Carpeta',
                'description' => '.',
                'created_id' => 1,
                'updated_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Crear Archivo',
                'description' => '.',
                'created_id' => 1,
                'updated_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Actualizar Archivo',
                'description' => '.',
                'created_id' => 1,
                'updated_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Eliminar Archivo',
                'description' => '.',
                'created_id' => 1,
                'updated_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
    }
}
