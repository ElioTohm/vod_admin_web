<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEpisodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('imdbID');
            // $table->primary('imdbID');
            $table->string('Title');
            $table->integer('Year');
            $table->string('Rated');
            $table->date('Released');
            $table->integer('season');
            $table->integer('episode');
            $table->integer('seriesID')->unsigned();
            $table->string('Runtime');
            $table->string('Director');
            $table->longText('Writer');
            $table->longText('Actors');
            $table->longText('Plot');
            $table->string('Language');
            $table->string('Country');
            $table->string('Awards');
            $table->string('Poster');
            $table->integer('Metascore');
            $table->float('imdbRating');
            $table->string('imdbVotes');
            $table->string('Type');
            $table->foreign('seriesID')
                  ->references('id')->on('series')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->string('stream');
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
        Schema::drop('episodes');
    }
}
