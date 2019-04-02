<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeSomeAirportsColumnsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('airports', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->integer('elevation_feet')->nullable()->change();
            $table->string('continent')->nullable()->change();
            $table->string('iso_country')->nullable()->change();
            $table->string('iso_region')->nullable()->change();
            $table->string('municipality')->nullable()->change();
            $table->string('coordinates')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('airports', function (Blueprint $table) {
            //
        });
    }
}
