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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('names');
            $table->string('lastname1');
            $table->string('lastname2')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('access')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('users_details', function(Blueprint $table){
            $table->id();
            $table->bigInteger('user_id')->unsigned()->index();
            $table->string('status', 100);
            $table->string('rol', 100);
            $table->boolean('is_driver');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_details');
        Schema::dropIfExists('users');
    }
};
