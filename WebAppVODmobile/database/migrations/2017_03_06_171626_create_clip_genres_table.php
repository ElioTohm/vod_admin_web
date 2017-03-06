<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClipGenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clip_genres', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->integer('genre_id')->unsigned();
            $table->primary(['id', 'genre_id']);
            $table->foreign('id')
                  ->references('id')->on('movies')
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
        Schema::drop('clip_genres');
    }
}
