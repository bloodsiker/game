<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMinesTable extends Migration
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
            $table->string('short_name');
            $table->string('code');
            $table->integer('accuracy')->default(8);
            $table->string('icon', 255);
            $table->boolean('is_active')->default(1);
            $table->integer('position')->default(1);
            $table->timestamps();
        });

        Schema::create('mine_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('currency_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->double('sum',16,8);
            $table->tinyInteger('count_mine');
            $table->float('coeff',10,2)->nullable();
            $table->double('won_sum',16,8)->default(0);
            $table->boolean('active')->default(true);
            $table->boolean('lose')->default(false);
            $table->string('mines');
            $table->string('revealed')->nullable();
            $table->tinyInteger('step')->nullable();
            $table->double('profit',16,8)->default(0);
            $table->double('remainder',16,8)->default(0);
            $table->dateTime('time_game');

            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('cards_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('currency_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->double('sum',16,8);
            $table->double('extra_sum',10,8);
            $table->boolean('is_extra')->default(0);
            $table->float('coeff',10,2)->nullable();
            $table->double('won_sum',16,8)->default(0);
            $table->double('min_won_sum',10,8)->default(0);
            $table->boolean('active')->default(true);
            $table->boolean('lose')->default(false);
            $table->smallInteger('attempts')->default(3);
            $table->json('cards');
            $table->string('revealed')->nullable();
            $table->double('profit',16,8)->default(0);
            $table->double('remainder',16,8)->default(0);
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
        Schema::dropIfExists('mine_histories');
        Schema::dropIfExists('currency');
    }
}
