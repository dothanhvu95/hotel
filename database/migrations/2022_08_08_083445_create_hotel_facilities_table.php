<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_facilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('hotel_id');
            $table->integer('have_swimming')->nullable()->default(1);
            $table->integer('have_wifi')->nullable()->default(1);
            $table->integer('have_restaurant')->nullable()->default(1);
            $table->integer('have_parking')->nullable()->default(1);
            $table->integer('have_meeting_room')->nullable()->default(1);
            $table->integer('have_elevator')->nullable()->default(1);
            $table->integer('have_fitness_center')->nullable()->default(1);
            $table->integer('have_open')->nullable()->default(1);
            $table->timestamps();
            $table->index('hotel_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotel_facilities');
    }
}
