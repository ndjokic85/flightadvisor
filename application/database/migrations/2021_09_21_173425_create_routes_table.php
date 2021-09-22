<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('airline', 3);
            $table->bigInteger('airline_id');
            $table->char('source_airport', 4);
            $table->bigInteger('source_airport_id')->unsigned();
            $table->char('destination_airport', 4);
            $table->bigInteger('destination_airport_id')->unsigned();
            $table->enum('codeshare', ['', 'Y']);
            $table->integer('stops')->default(0);
            $table->string('equipment');
            $table->decimal('price',6,2);
            $table->foreign('source_airport_id')->references('id')->on('airports')->onDelete('cascade');
            $table->foreign('destination_airport_id')->references('id')->on('airports')->onDelete('cascade');
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
        Schema::dropIfExists('routes');
    }
}
