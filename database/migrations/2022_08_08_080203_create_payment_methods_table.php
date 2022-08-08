<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CreatePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('code', 255);
            $table->integer('discount')->default(0);
            $table->tinyInteger('payment_online')->default(1)->comment('0: offline; 1: online');
            $table->string('description', 255)->nullable()->default(null);
            $table->timestamps();
        });

        DB::table('payment_methods')->INSERT([
            [
                'id' => 1,
                'name' => 'Tiền mặt',
                'code' => 'CASH',
                'payment_online' => 1,
                'description' => 'Thanh toán tiền mặt',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 2,
                'name' => 'Trực tuyến',
                'code' => 'ONL',
                'payment_online' => 0,
                'description' => 'Thanh toán Online',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            
            
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
}
