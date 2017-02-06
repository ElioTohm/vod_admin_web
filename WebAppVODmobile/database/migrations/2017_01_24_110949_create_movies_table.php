<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('imdbID');
            $table->string('Title');
            $table->string('Year');
            $table->string('Rated');
            $table->date('Released');
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
         Schema::drop('movies');
    }
}
