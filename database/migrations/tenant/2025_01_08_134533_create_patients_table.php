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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->enum('document_type', ['CC', 'CE', 'TI']);
            $table->string('document_number', 20)->unique();
            $table->string('first_name', 50);
            $table->string('middle_name', 50)->nullable();
            $table->string('last_name', 50);
            $table->string('second_last_name', 50)->nullable();
            $table->enum('gender', ['MALE', 'FEMALE', 'OTHER', 'INDETERMINATE'])->default('INDETERMINATE');
            $table->date('date_of_birth');
            $table->string('address', 255)->nullable();
            $table->string('nationality', 100)->nullable();
            $table->boolean('is_donor')->default(false);
            $table->enum('blood_type', ['O_POSITIVE', 'O_NEGATIVE', 'A_POSITIVE', 'A_NEGATIVE', 'B_POSITIVE', 'B_NEGATIVE', 'AB_POSITIVE', 'AB_NEGATIVE'])->nullable();
            $table->boolean('has_special_condition')->default(false);
            $table->text('special_condition')->nullable();
            $table->boolean('has_allergies')->default(false);
            $table->text('allergies')->nullable();
            $table->boolean('has_surgeries')->default(false);
            $table->text('surgeries')->nullable();
            $table->boolean('has_medical_history')->default(false);
            $table->text('medical_history')->nullable();
            $table->string('eps', 255)->nullable();
            $table->string('afp', 255)->nullable();
            $table->string('arl', 255)->nullable();
            $table->string('affiliate_type', 50)->nullable();
            $table->string('branch_office', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
