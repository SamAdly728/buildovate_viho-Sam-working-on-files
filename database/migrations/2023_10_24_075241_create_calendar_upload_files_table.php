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
        Schema::create('calendar_upload_files', function (Blueprint $table) {
            $table->id('file_id');
            $table->integer('appointment_id');
            $table->string('file_name');
            $table->string('file_type');
            $table->string('s3_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendar_upload_files');
    }
};
