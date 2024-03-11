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
        Schema::table('to_dos', function (Blueprint $table) {
            $table->timestamp('start_date')->nullable()->after('description');
            $table->timestamp('due_date')->nullable()->after('start_date');
            $table->text('labels')->nullable()->after('reminder_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('to_dos', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'due_date', 'labels']);
        });
    }
};
