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
        Schema::create('drivers', function(Blueprint $table){
            $table->id();
            $table->bigInteger('users_id')->unsigned()->index();
            $table->string('names', 100);
            $table->string('lastname1', 100);
            $table->string('lastname2', 100)->nullable();
            $table->string('status', 100);
            $table->string('photo', 100)->nullable();
            $table->string('rfc', 50)->nullable();
            $table->timestamps();
            
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
        });


        Schema::create('drivers_schedule', function(Blueprint $table){
            $table->id();
            $table->bigInteger('drivers_id')->unsigned()->index();
            $table->date('date');
            $table->timestamps();

            $table->foreign('drivers_id')->references('id')->on('drivers')->onDelete('cascade');
        });

        Schema::create('drivers_document', function(Blueprint $table){
            $table->id();
            $table->bigInteger('drivers_id')->unsigned()->index();
            $table->string('type', 50);
            $table->string('number', 50);
            $table->date('expiration_date')->nullable();
            $table->timestamps();

            $table->foreign('drivers_id')->references('id')->on('drivers')->onDelete('cascade');
        });

        Schema::create('drivers_document_image', function(Blueprint $table){
            $table->id();
            $table->bigInteger('drivers_document_id')->unsigned()->index();
            $table->string('name');
            $table->timestamps();

            $table->foreign('drivers_document_id')->references('id')->on('drivers_document')->onDelete('cascade');
        });

        Schema::create('drivers_phone', function(Blueprint $table){
            $table->id();
            $table->bigInteger('drivers_id')->unsigned()->index();
            $table->string('type', 100);
            $table->string('number', 15);
            $table->timestamps();

            $table->foreign('drivers_id')->references('id')->on('drivers')->onDele('cascade');
        });

        Schema::create('drivers_address', function(Blueprint $table){
            $table->id();
            $table->bigInteger('drivers_id')->unsigned()->index();
            $table->string('street', 150);
            $table->string('int_number', 10)->nullable();
            $table->string('ext_number', 10);
            $table->string('colony', 100);
            $table->string('state', 100);
            $table->string('municipality');
            $table->bigInteger('zip_code');
            $table->boolean('isFiscal')->default(true); 
            $table->timestamps();

            $table->foreign('drivers_id')->references('id')->on('drivers')->onDelete('cascade');
        });

        Schema::create('drivers_vehicle', function(Blueprint $table){
            $table->id();
            $table->bigInteger('drivers_id')->unsigned()->index();
            $table->string('brand', 50);
            $table->string('model', 50);
            $table->string('color', 20);
            $table->string('plate', 10)->unique();
            $table->integer('year', false)->unsigned();
            $table->timestamps();

            $table->foreign('drivers_id')->references('id')->on('drivers')->onDelete('cascade');
        });
        
        Schema::create('drivers_vehicle_policy', function(Blueprint $table){
            $table->id();
            $table->bigInteger('drivers_vehicle_id')->unsigned()->index();
            $table->string('type', 50);
            $table->string('number', 50);
            $table->date('expiration_date')->nullable();
            $table->string('company', 100);
            $table->string('image', 150)->nullable();
            $table->timestamps();

            $table->foreign('drivers_vehicle_id')->references('id')->on('drivers_vehicle')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schedule::dropIfExists('drivers_vehicle_policy');
        Schedule::dropIfExists('drivers_vehicle');
        Schedule::dropIfExists('drivers_address');
        Schedule::dropIfExists('drivers_phone');
        Schedule::dropIfExists('drivers_document_image');
        Schedule::dropIfExists('drivers_document');
        Schedule::dropIfExists('drivers_schedule');
        Schedule::dropIfExists('drivers');
    }
};
