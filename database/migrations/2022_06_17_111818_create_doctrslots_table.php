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
        Schema::create('doctrslots', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userId')->unsigned()->index();
            $table->string('name');;
            $table->string('day');
            $table->string('time');

        });
        Schema::table('doctrslots', function (Blueprint $table) {
            $table->foreign('userId')->references('userId')->on('doctors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctrslots');
    }
};
