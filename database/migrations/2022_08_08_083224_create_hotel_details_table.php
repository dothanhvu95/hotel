<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('hotel_id');
            $table->integer('four_bedrooms')->nullable()->default(1);
            $table->integer('one_bedrooms')->nullable()->default(1);
            $table->integer('two_bedrooms')->nullable()->default(1);
            $table->integer('is_hotel')->nullable()->default(1);
            $table->integer('two_Bathrooms')->nullable()->default(1);
            $table->integer('sqft')->nullable()->default(null);
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
        Schema::dropIfExists('hotel_details');
    }
}
