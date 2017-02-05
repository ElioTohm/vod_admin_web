<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSerieGenres extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serie_genres', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->integer('genre_id')->unsigned();
            $table->primary(['id', 'genre_id']);
            $table->foreign('id')
                  ->references('id')->on('series')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('genre_id')
                  ->references('genre_id')->on('genres')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('serie_genres');
    }
}
