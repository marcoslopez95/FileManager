<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFolderUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folder_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('folder_id')->constrained()->onUpdate('cascade')
                ->onDelete('No action');
            $table->foreignId('permit_id')->constrained()->onUpdate('cascade')
                ->onDelete('No action');
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')
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
        Schema::dropIfExists('folder_users');
    }
}
