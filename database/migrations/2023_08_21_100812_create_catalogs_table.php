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
        Schema::create('catalogs', function (Blueprint $table) {
            $table->id();
            $table->integer('product_category_id')->default(0);
            $table->integer('product_type_id');
            $table->integer('design_club')->default(0);
            $table->string('title');
            $table->string('front_photo');
            $table->string('back_photo');
            $table->string('leftchest_photo');
            $table->string('left_photo');
            $table->string('right_photo');
            $table->string('front_mockup_url');
            $table->string('back_mockup_url');
            $table->string('left_mockup_url');
            $table->string('right_mockup_url');
            $table->string('mockup_url');
            $table->string('mockup_220');
            $table->string('ctw');
            $table->string('ppe');
            $table->string('description');
            $table->string('design');
            $table->string('sku');
            $table->string('option1');
            $table->string('option2');
            $table->string('option3');
            $table->string('niche');
            $table->integer('qa')->default(0);
            $table->integer('qa_by')->default(0);
            $table->integer('admin_qa')->default(0);
            $table->integer('marketplace_id')->default(0);
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->string('user_id');
            $table->string('vendorID');
            $table->dateTime('date_created');
            $table->dateTime('date_updated');
            $table->integer('is_reviewed')->default(0);
            $table->integer('is_reviewed_by')->default(0);
            $table->integer('for_removal')->default(0);
            $table->integer('recreated')->default(0);
            $table->integer('recreated_from_admin')->default(0);
            $table->integer('regen')->default(0);
            $table->integer('variant_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogs');
    }
};
