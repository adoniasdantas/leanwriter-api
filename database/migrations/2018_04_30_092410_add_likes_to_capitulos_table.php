<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLikesToCapitulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('capitulos', function (Blueprint $table) {
            $table->integer('likes')->default(0)->unsigned();
            $table->integer('dislikes')->default(0)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('capitulos', function (Blueprint $table) {
            $table->dropColumn(['likes', 'dislikes']);
        });
    }
}
