<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Archive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
 public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('archive', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_machines')->unsigned();
            $table->string('status');
            $table->string('status_user');
            $table->text('status_desc');
            $table->date('overwiew_date');
            $table->timestamp('created_at')->nullable();

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
        Schema::dropIfExists('archive');
    }
}
