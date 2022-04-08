<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilePermitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_permit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_id')->constrained()->onUpdate('cascade')
                ->onDelete('No action');
            $table->foreignId('permit_id')->constrained()->onUpdate('cascade')
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
        Schema::dropIfExists('file_permit');
    }
}