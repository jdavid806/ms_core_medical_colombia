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
        Schema::create('exam_recipe_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_recipe_id')->constrained('exam_recipes');
            $table->foreignId('uploaded_by_user_id')->constrained('users');
            $table->string('result_minio_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_recipe_results');
    }
};
