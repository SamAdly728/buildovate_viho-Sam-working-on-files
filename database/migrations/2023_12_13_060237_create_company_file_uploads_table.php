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
        Schema::create('company_file_uploads', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id')->constrained('companies')->cascadeOnDelete()->nullable()->comment("reference id linked to companies table");
            $table->string('file_name');
            $table->string('file_type');
            $table->integer('file_size');
            $table->text('s3_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_file_uploads');
    }
};
