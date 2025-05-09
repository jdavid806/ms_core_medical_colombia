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
        Schema::table('patients', function (Blueprint $table) {
            // Eliminar campos
            $table->dropColumn([
                'blood_type',
                'is_donor',
                'has_special_condition',
                'special_condition',
                'has_allergies',
                'allergies',
                'has_surgeries',
                'surgeries',
                'has_medical_history',
                'medical_history',
                'eps',
                'afp',
                'arl',
                'affiliate_type',
                'branch_office',
                'is_active',
                'regime_id'
            ]);

            // Agregar nuevo campo
            $table->string('ethnicity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            // Agregar campos eliminados
            $table->string('blood_type')->nullable();
            $table->boolean('is_donor')->default(false);
            $table->boolean('has_special_condition')->default(false);
            $table->text('special_condition')->nullable();
            $table->boolean('has_allergies')->default(false);
            $table->text('allergies')->nullable();
            $table->boolean('has_surgeries')->default(false);
            $table->text('surgeries')->nullable();
            $table->boolean('has_medical_history')->default(false);
            $table->text('medical_history')->nullable();
            $table->string('eps')->nullable();
            $table->string('afp')->nullable();
            $table->string('arl')->nullable();
            $table->string('affiliate_type')->nullable();
            $table->string('branch_office')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('regime_id')->nullable();

            // Eliminar el campo agregado
            $table->dropColumn('ethnicity');
        });
    }
};
