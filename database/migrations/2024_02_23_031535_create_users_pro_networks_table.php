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
        Schema::create('users_pro_networks', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->constrained('users')->cascadeOnDelete()->nullable()->comment("reference id linked to users table");
            $table->integer('pro_user_id')->constrained('users')->cascadeOnDelete()->nullable()->comment("reference id linked to users table");
            $table->integer('pro_id')->constrained('users')->cascadeOnDelete()->nullable()->comment("reference id linked to pro_users table");
            $table->string('status')->default('pending')->comment('pending, accepted, declined');
            $table->dateTime('date_accepted')->nullable();
            $table->dateTime('date_declined')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_pro_networks');
    }
};
