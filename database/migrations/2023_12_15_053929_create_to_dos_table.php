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
        Schema::dropIfExists('to_dos');
        Schema::create('to_dos', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('entityId')->nullable();
            $table->string('entityType')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->integer('is_completed')->default(0);
            $table->integer('is_deleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('to_dos');
    }
};
