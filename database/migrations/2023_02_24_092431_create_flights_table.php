<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->integer('countryOfDispatch_id');
            $table->integer('citiOfDispatch_id');
            $table->date('dateOfDispatch');
            $table->integer('countryOfArrival_id');
            $table->integer('citiOfArrival_id');
            $table->date('dateOfArrival');
            $table->integer('aircraft_id');
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
        Schema::dropIfExists('flights');
    }
}
