<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DenunciationAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('denunciation_address', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('denunciation_id');
            $table->foreign('denunciation_id')->references('id')->on('denunciations');

            $table->unsignedBigInteger('address_id');
            $table->foreign('address_id')->references('id')->on('address');

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
        Schema::dropIfExists('address');
    }
}
