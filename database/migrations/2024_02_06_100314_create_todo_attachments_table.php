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
        Schema::create('todo_attachments', function (Blueprint $table) {
            $table->increments('id')->unsigned(); // 'id' as an auto-incrementing unsigned integer
            $table->integer('user_id')->nullable(); // Nullable integer for 'user_id'
            $table->integer('todo_id')->nullable(); // Nullable integer for 'todo_id'
            $table->string('file_name')->nullable(); // Nullable string for 'file_name'
            $table->string('file_type')->nullable(); // Nullable string for 'file_type'
            $table->integer('file_size')->nullable(); // Nullable integer for 'file_size'
            $table->string('s3_path')->nullable(); // Nullable string for 's3_path'
            $table->string('s3_url')->nullable(); // Nullable string for 's3_url'
            $table->timestamp('created_at')->nullable(); // Nullable timestamp for 'created_at'
            $table->timestamp('updated_at')->nullable(); // Nullable timestamp for 'updated_at'
            $table->integer('is_deleted_s3_flag')->nullable(); // Nullable integer for 'is_deleted_s3_flag'
            $table->timestamp('deleted_at')->nullable(); // Nullable timestamp for 'deleted_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todo_attachments');
    }
};
