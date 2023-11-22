<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('states', function(Blueprint $table){
            $table->id();
            $table->string('name', 100);
            $table->timestamps();
        });

        Schema::create('municipalities', function(Blueprint $table){
            $table->id();
            $table->bigInteger('states_id')->unsigned()->index();
            $table->string('name', 150);
            $table->timestamps();

            $table->foreign('states_id')->references('id')->on('states');
        });

        Schema::create('zip_codes', function(Blueprint $table){
            $table->id();
            $table->bigInteger('municipalities_id')->unsigned()->index();
            $table->string('zip_code', 10);
            $table->string('latitude', 50);
            $table->string('longitude', 50);
            $table->timestamps();

            $table->foreign('municipalities_id')->references('id')->on('municipalities');
        });

        Schema::create('colonies', function(Blueprint $table){
            $table->id();
            $table->bigInteger('zip_codes_id')->unsigned()->index();
            $table->string('name', 150);
            $table->timestamps();

            $table->foreign('zip_codes_id')->references('id')->on('zip_codes');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colinies');
        Schema::dropIfExists('zip_codes');
        Schema::dropIfExists('municipalities');
        Schema::dropIfExists('states');
    }
};
