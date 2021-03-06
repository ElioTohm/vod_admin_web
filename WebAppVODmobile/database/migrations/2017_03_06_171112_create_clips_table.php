<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clips', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Title');
            $table->string('stream');
            $table->string('Subtitle')->nullable();
            $table->integer('artist_id')->unsigned();
            $table->foreign('artist_id')
                  ->references('id')->on('artists')
                  ->onDelete('cascade');
            $table ->timestamps();
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clips');
    }
}
