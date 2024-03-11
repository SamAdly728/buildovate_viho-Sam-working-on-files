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
        Schema::create('facebook_api', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('facebook_user_id');
            $table->string('facebook_user_name');
            $table->string('facebook_user_email');
            $table->string('facebook_user_token');
            $table->string('facebook_user_avatar_url');
            $table->string('page_id');
            $table->string('page_token');
            $table->string('page_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facebook_api');
    }
};
