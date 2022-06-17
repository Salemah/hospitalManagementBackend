<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dcId')->unsigned()->index();
            $table->integer('patientId');
            $table->string('patientname');
            $table->string('doctor');
            $table->string('phone');
            $table->string('day');
            $table->string('time');

        });
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreign('dcId')->references('userId')->on('doctrslots')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};
