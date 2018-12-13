<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buses', function (Blueprint $table) {
            $table->increments('id');
            $table->string ('bus_product_name');
            $table->string ('bus_plate_no');
            $table->integer ('driver_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('buses', function ($table) {
                $table
                    ->foreign('driver_id')
                    ->references('id')
                    ->on('drivers')
                    ->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buses');
    }
}
