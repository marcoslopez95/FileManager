<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermitRolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permit_rol', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permit_id')->constrained()->onUpdate('cascade')
                ->onDelete('No action');
            $table->foreignId('rol_id')->constrained()->onUpdate('cascade')
                ->onDelete('No action');
            $table->unsignedBigInteger('created_id')->comment('Id del usuario que creó el registro');
            $table->unsignedBigInteger('updated_id')->comment('Id del usuario que actualizó el registro');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permit_rol');
    }
}