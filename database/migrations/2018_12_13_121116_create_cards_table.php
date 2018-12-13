<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('card_number');
            $table->string('card_holder_name');
            $table->integer('expiry_month');
            $table->integer('expiry_year');
            $table->string('cvv');
            $table->timestamps();
        });
        Schema::table ('cards', function(Blueprint $table){
            $table
                    ->foreign('user_id')
                    ->references('id')
                    ->on('users')
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
        Schema::dropIfExists('cards');
    }
}
