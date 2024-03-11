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
        Schema::table('pro_users', function (Blueprint $table) {
            $table->integer('user_id')->constrained('users')->cascadeOnDelete()->nullable()->comment("reference id linked to users table");
            $table->string('business_image')->nullable();
            $table->integer('is_licensed')->default(0);
            $table->string('license_number')->nullable();
            $table->string('occupation')->nullable();
            $table->string('status')->default('pending');
            $table->dateTime('active_since')->nullable();
            $table->integer('added_by_id')->constrained('users')->cascadeOnDelete()->nullable()->comment("reference id linked to users table");
            $table->timestamps();
        });

        // ALTER TABLE `pro_users` ADD `user_id` INT NULL DEFAULT NULL AFTER `token_created_at`, ADD `business_image` VARCHAR(255) NULL DEFAULT NULL AFTER `user_id`, ADD `is_licensed` INT NOT NULL DEFAULT '0' AFTER `business_image`, ADD `license_number` VARCHAR(255) NULL DEFAULT NULL AFTER `is_licensed`, ADD `occupation` VARCHAR(255) NULL DEFAULT NULL AFTER `license_number`, ADD `status` VARCHAR(255) NOT NULL DEFAULT 'pending' AFTER `occupation`, ADD `active_since` DATETIME NULL DEFAULT NULL AFTER `status`, ADD `added_by_id` INT NULL DEFAULT NULL AFTER `active_since`, ADD `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP AFTER `added_by_id`, ADD `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
