<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->text('accident_address');
            $table->text('accident_report');
            $table->text('image_path');
            $table->integer('driver_id')->unsigned();
            $table->timestamps();
        });
        Schema::table(
            'reports', function ($table) {
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
        Schema::dropIfExists('reports');
    }
}
