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
        Schema::create('services', function(Blueprint $table){
            $table->id();
            $table->bigInteger('warehouses_id')->unsigned()->index();
            $table->bigInteger('clients_id')->unsigned()->index();
            $table->date('date');
            $table->time('time');
            $table->string('guide_number')->unique();
            $table->string('route_number');
            $table->string('status', 100);
            $table->string('contact_name', 100);
            $table->string('address', 200);
            $table->string('zip_code', 10);
            $table->string('city', 100);
            $table->string('colony', 100);
            $table->string('int_number', 10)->nullable();
            $table->string('ext_number', 10);
            $table->boolean('assigned')->default(false);
            $table->timestamps();

            $table->foreign('warehouses_id')->references('id')->on('warehouses');
            $table->foreign('clients_id')->references('id')->on('clients');
        });

        Schema::create('services_drivers', function(Blueprint $table){
            $table->id();
            $table->bigInteger('services_id')->unsigned()->index();
            $table->bigInteger('drivers_id')->unsigned()->index();
            $table->date('date');
            $table->time('time');
            $table->string('status');
            $table->string('observations', 300)->nullable();
            $table->timestamps();

            $table->foreign('services_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('drivers_id')->references('id')->on('drivers')->onDelete('cascade');
        });

        Schema::create('services_drivers_exception', function(Blueprint $table){
            $table->id();
            $table->bigInteger('services_drivers_id')->unsigned()->index();
            $table->date('date');
            $table->time('hour');
            $table->string('reason');
            $table->timestamps();

            $table->foreign('services_drivers_id')->references('id')->on('services_drivers')->onDelete('cascade');
        });

        Schema::create('services_drivers_image', function(Blueprint $table){
            $table->id();
            $table->bigInteger('services_drivers_id')->unsigned()->index();
            $table->string('name', 100);
            $table->string('type', 100);
            $table->string('url', 150);
            $table->timestamps();

            $table->foreign('services_drivers_id')->references('id')->on('services_drivers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services_drivers_image');
        Schema::dropIfExists('services_drivers_exception');
        Schema::dropIfExists('services_drivers');
        Schema::dropIfExists('services');
    }
};
