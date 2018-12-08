<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersMachines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('users_machines', function (Blueprint $table) {
            $table->integer('id_users')->unsigned();
            $table->integer('id_machines')->unsigned();

            $table->foreign('id_users')->references('id')->on('users')->onDelete('cascade'); // onDelete usun jak nie istnieje polaczenie
            $table->foreign('id_machines')->references('id')->on('machines')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_machines');
    }
}
