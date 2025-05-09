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
        Schema::create('exam_package_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_package_id')->constrained('exam_packages');
            $table->integer('exam_package_item_id');
            $table->string('exam_package_item_type', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_package_items');
    }
};
