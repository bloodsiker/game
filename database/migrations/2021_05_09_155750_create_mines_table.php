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
        Schema::create('mines', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->double('sum',10,2);
            $table->tinyInteger('count_mine');
            $table->double('coeff',10,2)->nullable();
            $table->double('won_sum',10,2)->default(0);
            $table->boolean('active')->default(true);
            $table->boolean('lose')->default(false);
            $table->string('mines');
            $table->string('revealed');
            $table->tinyInteger('step')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('mines');
    }
}
