<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Denunciations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('denunciations', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('phone_id');
            $table->foreign('phone_id')->references('id')->on('phones');

            $table->unsignedBigInteger('denunciations_type_id');
            $table->foreign('denunciations_type_id')->references('id')->on('denunciations_type');

            $table->string('code', 30);
            $table->longText('description');
            $table->boolean('active');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('denunciations');
    }
}
