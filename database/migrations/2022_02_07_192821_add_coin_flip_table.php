<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCoinFlipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coinflip_rates', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('step');
            $table->float('coeff',10,2);
            $table->boolean('finish')->default(0);
        });

        Schema::create('coinflip_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('currency_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->double('bet',10,2);
            $table->float('coeff',10,2)->nullable();
            $table->double('won_sum',10,2)->default(0);
            $table->boolean('active')->default(true);
            $table->boolean('lose')->default(false);
            $table->string('coins');
            $table->string('revealed')->nullable();
            $table->tinyInteger('step')->nullable();
            $table->double('profit',10,2)->default(0);
            $table->double('remainder',10,2)->default(0);
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
        Schema::dropIfExists('coinflip_histories');
        Schema::dropIfExists('coinflip_rates');
    }
}
