<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('game_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->double('sum');
            $table->float('coeff',10,2);
            $table->double('result');
            $table->timestamps();

            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('mine_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('currency_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->double('sum');
            $table->tinyInteger('count_mine');
            $table->float('coeff',10,2)->nullable();
            $table->double('won_sum')->default(0);
            $table->boolean('active')->default(true);
            $table->boolean('lose')->default(false);
            $table->string('mines');
            $table->string('revealed')->nullable();
            $table->tinyInteger('step')->nullable();
            $table->double('profit')->default(0);
            $table->double('remainder')->default(0);
            $table->dateTime('time_game');

            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('dice_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('currency_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->tinyInteger('under_over');
            $table->double('bet');
            $table->double('profit');
            $table->double('multiplier');
            $table->double('roll');
            $table->double('remainder');
            $table->string('target', 10);
            $table->dateTime('time_game');

            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('keno_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('currency_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->double('bet');
            $table->double('profit');
            $table->tinyInteger('type')->default(1);
            $table->double('coeff');
            $table->double('remainder');
            $table->string('user_numbers');
            $table->string('drop_numbers')->nullable();
            $table->string('win_numbers')->nullable();
            $table->dateTime('time_game');

            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('coinflip_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('currency_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->double('bet');
            $table->float('coeff')->nullable();
            $table->double('won_sum')->default(0);
            $table->boolean('active')->default(true);
            $table->boolean('lose')->default(false);
            $table->string('coins');
            $table->string('revealed')->nullable();
            $table->tinyInteger('step')->nullable();
            $table->double('profit')->default(0);
            $table->double('remainder')->default(0);
            $table->dateTime('time_game');

            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('cards_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('currency_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->double('sum');
            $table->double('extra_sum');
            $table->boolean('is_extra')->default(0);
            $table->float('coeff')->nullable();
            $table->double('won_sum')->default(0);
            $table->double('min_won_sum')->default(0);
            $table->boolean('active')->default(true);
            $table->boolean('lose')->default(false);
            $table->smallInteger('attempts')->default(3);
            $table->json('cards');
            $table->string('revealed')->nullable();
            $table->double('profit')->default(0);
            $table->double('remainder')->default(0);
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
        Schema::dropIfExists('card_histories');
        Schema::dropIfExists('dice_histories');
        Schema::dropIfExists('mine_histories');
        Schema::dropIfExists('keno_histories');
        Schema::dropIfExists('coinflip_histories');
        Schema::dropIfExists('game_histories');
    }
}
