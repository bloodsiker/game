<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKenoRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keno_rates', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('number');
            $table->tinyInteger('count_win');
            $table->float('coeff',10,2);
        });

        Schema::create('keno_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('currency_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->double('bet',10,2);
            $table->double('profit',10,2);
            $table->double('coeff',10,2);
            $table->double('remainder',10,2);
            $table->string('user_numbers');
            $table->string('drop_numbers')->nullable();
            $table->string('win_numbers')->nullable();
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
        Schema::dropIfExists('keno_rates');
        Schema::dropIfExists('keno_histories');
    }
}
