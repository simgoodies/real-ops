<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flights', function (Blueprint $table) {
            $table->foreign('event_id')->references('id')->on('events')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('pilot_id')->references('id')->on('pilots')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flights', function (Blueprint $table) {
            $table->dropForeign('flights_pilot_id_foreign');
            $table->dropForeign('flights_event_id_foreign');
        });
    }
}
