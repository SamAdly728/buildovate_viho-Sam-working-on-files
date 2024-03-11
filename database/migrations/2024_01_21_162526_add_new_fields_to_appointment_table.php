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
        Schema::table('appointment', function (Blueprint $table) {
            $table->timestamp('start_date')->nullable()->after('Meeting_date');
            $table->timestamp('end_date')->nullable()->after('start_date');
            $table->string('entityType', 100)->nullable()->after('end_date');
            $table->integer('entityId')->nullable()->after('entityType');
            $table->tinyInteger('reminder_sms')->default(0)->nullable()->after('entityId');
            $table->tinyInteger('reminder_email')->default(0)->nullable()->after('reminder_sms');
            $table->integer('assignedToUserId', 11)->nullable()->after('reminder_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointment', function (Blueprint $table) {
            $table->dropColumn([
                'start_date',
                'end_date',
                'entityType',
                'entityId',
                'reminder_sms',
                'reminder_email',
                'assignedToUserId'
            ]);
        });
    }
};
