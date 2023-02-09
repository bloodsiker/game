<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserStatistics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_statistics', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('currency_id')->unsigned();
            $table->decimal('wagered', 19, 8)->default(0);
            $table->decimal('profit', 19, 8)->default(0);
            $table->integer('dice')->default(0);
            $table->integer('mines')->default(0);
            $table->integer('coinflip')->default(0);
            $table->integer('keno')->default(0);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_statistics');
    }
}
