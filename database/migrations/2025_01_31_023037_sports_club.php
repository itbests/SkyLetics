<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sports_club', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('identification_type_id');
            $table->string('identification')->index();
            $table->string('name_')->index();
            $table->unsignedBigInteger('city_id')->index();
            $table->string('address');
            $table->string('zipcode');
            $table->string('phone1');
            $table->string('phone2');
            $table->string('email');
            $table->timestamp('founding_date')->nullable();
            $table->timestamp('register_date')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->foreign('identification_type_id')->references('id')->on('identification_type');
            $table->foreign('status_id')->references('id')->on('status');
            $table->foreign('city_id')->references('id')->on('city');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sports_club');
    }
};
