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
        Schema::create('user_file_upload', function (Blueprint $table) {
            $table->id('user_file_upload_id');
            $table->integer('user_id');
            $table->string('file_name');
            $table->string('file_type');
            $table->integer('file_size');
            $table->string('s3_path');
            $table->string('upload_from');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_file_upload');
    }
};
