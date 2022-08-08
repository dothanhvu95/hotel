<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('price');
            $table->text('description');
            $table->string('address');
            $table->integer('is_recommand')->nullable()->default(1)->comment('1:false 2: true');
            $table->integer('is_popular')->nullable()->default(1)->comment('1:false 2: true');
            $table->integer('is_trending')->nullable()->default(1)->comment('1:false 2: true');
            $table->integer('city_id');
            $table->integer('district_id');
            $table->integer('ward_id');
            $table->integer('status')->nullable()->default(1)->comment('1:active 2:sold, 3:deactive');
            $table->timestamps();
            $table->index('city_id');
            $table->index('district_id');
            $table->index('ward_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotels');
    }
}
