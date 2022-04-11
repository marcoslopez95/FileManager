<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ArreglandoRelacionFilesUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('file_permits');
        Schema::create('file_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_id')->constrained()->onUpdate('cascade')
                ->onDelete('No action');
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')
                ->onDelete('No action');
            $table->unsignedBigInteger('created_id')->comment('Id del usuario que creó el registro');
            $table->unsignedBigInteger('updated_id')->comment('Id del usuario que actualizó el registro');
            $table->timestamps();
        });
        Schema::create('file_user_permit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('file_user_id');
            $table->foreign('file_user_id')->references('id')->on('file_user')->onUpdate('cascade')
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
        Schema::table('file_user', function (Blueprint $table) {
            //
        });
    }
}