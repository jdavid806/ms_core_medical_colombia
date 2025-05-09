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
        Schema::create('comission_config', function (Blueprint $table) {
            $table->id();
            $table->string('attention_type');
            $table->string('application_type');
            $table->string('commission_type');
            $table->string('percentage_base')->nullable();
            $table->string('percentage_value')->nullable();
            $table->decimal('commission_value', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comission_config');
    }
};
