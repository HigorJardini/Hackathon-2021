<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DenunciationFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('denunciation_files', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('file_id');
            $table->foreign('file_id')->references('id')->on('files');

            $table->unsignedBigInteger('denunciation_id');
            $table->foreign('denunciation_id')->references('id')->on('denunciations');

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
        Schema::dropIfExists('denunciation_files');
    }
}
