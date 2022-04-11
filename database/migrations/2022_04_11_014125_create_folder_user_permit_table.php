<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFolderUserPermitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('folder_user', function (Blueprint $table) {
            $table->dropColumn('permit_id');
        });
        Schema::create('folder_user_permit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('folder_user_id');
            $table->foreign('folder_user_id')->references('id')->on('folder_user')
                ->onDelete('No action');

            $table->foreignId('permit_id')->constrained()->onUpdate('cascade')
                ->onDelete('No action');
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
        Schema::dropIfExists('folder_user_permit');
        Schema::create('folder_user', function (Blueprint $table) {
            $table->foreignId('permit_id')->constrained()->onUpdate('cascade')
                ->onDelete('No action');
        });
    }
}
