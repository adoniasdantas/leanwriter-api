<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCapituloDislikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capitulo_dislikes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('capitulo_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('capitulo_id')->references('id')->on('capitulos')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('capitulo_dislikes');
    }
}
