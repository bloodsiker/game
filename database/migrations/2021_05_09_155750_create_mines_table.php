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
        Schema::create('mine_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('currency_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->double('sum',10,2);
            $table->tinyInteger('count_mine');
            $table->float('coeff',10,2)->nullable();
            $table->double('won_sum',10,2)->default(0);
            $table->boolean('active')->default(true);
            $table->boolean('lose')->default(false);
            $table->string('mines');
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
        Schema::dropIfExists('mine_histories');
    }
}
