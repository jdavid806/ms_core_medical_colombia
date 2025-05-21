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
        Schema::create('copayment_rules', function (Blueprint $table) {
            $table->id();

            $table->enum('attention_type', ['consultation', 'procedure']);
            $table->enum('type_scheme', ['contributory', 'subsidiary']);

            $table->enum('category', ['A', 'B', 'C'])->nullable(); // Only for contributory
            $table->enum('level', ['1', '2'])->nullable();        // Only for subsidiary

            $table->enum('type', ['fixed', 'percentage']);
            $table->decimal('value', 10, 2); // fixed amount or percentage

            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();

            $table->timestamps();

            $table->softDeletes();

            $table->unique([
                'attention_type',
                'type_scheme',
                'category',
                'level'
            ], 'unique_rule_per_combination');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('copayment_rules');
    }
};
