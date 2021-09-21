<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAirportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airports', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->char('iata', 3)->nullable();
            $table->char('icao', 4)->nullable();
            $table->decimal('latitude', 30, 25);
            $table->decimal('longitude', 30, 25);
            $table->integer('altitude');
            $table->integer('timezone');
            $table->enum('dst', ['E', 'N', 'A', 'S', 'O', 'Z', 'U']);
            $table->string('tz');
            $table->string('type');
            $table->string('source');
            $table->bigInteger('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
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
        Schema::dropIfExists('airports');
    }
}
