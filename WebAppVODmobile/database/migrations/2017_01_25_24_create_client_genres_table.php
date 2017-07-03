<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientGenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_genres', function (Blueprint $table) {
            $table->integer('client_id')->unsigned();
            $table->integer('genre_id')->unsigned();
            $table->primary(['client_id', 'genre_id']);
            $table->foreign('client_id')
                  ->references('id')->on('clients')
                  ->onDelete('cascade');
            $table->foreign('genre_id')
                  ->references('genre_id')->on('genres')
                  ->onDelete('cascade');
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
        Schema::drop('client_genres');
    }
}
