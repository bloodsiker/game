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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('idc');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

        Schema::create('faucet_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('currency_id')->unsigned();
            $table->double('amount');
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
            $table->double('bet',10,2);
            $table->double('profit',10,2);
            $table->double('multiplier',10,4);
            $table->double('roll',10,3);
            $table->double('remainder',10,2);
            $table->string('target', 10);
            $table->dateTime('time_game');

            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('games', function (Blueprint $table) {
            $table->double('edge');
            $table->double('max_win');
            $table->double('min_bid');
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
        Schema::dropIfExists('currency');

        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn(['max_win', 'min_bid']);
        });
    }
}
