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
        Schema::create('warehouses', function(Blueprint $table){
            $table->id();
            $table->bigInteger('zip_codes_id')->unsigned()->index();
            $table->string('name', 100);            
            $table->timestamps();

            $table->foreign('zip_codes_id')->references('id')->on('zip_codes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
