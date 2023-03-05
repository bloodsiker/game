<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faucet_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('currency_id')->unsigned();
            $table->double('amount', 16, 8);
            $table->string('description')->nullable();
            $table->tinyInteger('type');
            $table->dateTime('date');

            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('dice_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('currency_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->tinyInteger('under_over');
            $table->double('bet',16,8);
            $table->double('profit',16,8);
            $table->double('multiplier',10,4);
            $table->double('roll',10,3);
            $table->double('remainder',16,8);
            $table->string('target', 10);
            $table->dateTime('time_game');

            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dice_history');
        Schema::dropIfExists('faucet_history');
    }
}
