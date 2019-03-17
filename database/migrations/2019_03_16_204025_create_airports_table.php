<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('icao', '4')->unique();
            $table->string('iata', 3)->nullable()->unique();
            $table->string('name');
            $table->integer('elevation_feet');
            $table->string('continent');
            $table->string('iso_country');
            $table->string('iso_region');
            $table->string('municipality');
            $table->string('coordinates');
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
        Schema::dropIfExists('airports');
    }
}
