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
        Schema::create('social_securities', function (Blueprint $table) {
            $table->id();
            $table->string('type_scheme')->nullable();
            $table->string('affiliate_type')->nullable();
            $table->string('category')->nullable();
            $table->string('eps')->nullable();
            $table->string('arl')->nullable();
            $table->string('afp')->nullable();
            $table->string('branch_office')->nullable();
            $table->string('insurer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_securities');
    }
};
