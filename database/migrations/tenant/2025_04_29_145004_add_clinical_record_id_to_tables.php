<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $tables = [
            'patient_disabilities', 
            'vaccine_applications', 
            'recipes',  
            'exam_recipes',  
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->unsignedBigInteger('clinical_record_id')->nullable();
                $table->foreign('clinical_record_id')->references('id')->on('clinical_records');
            });
        }
    }

    public function down(): void
    {
        $tables = [
            'patient_disabilities', 
            'vaccine_applications', 
            'recipes',  
            'exam_recipes', 
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropForeign(['clinical_record_id']);
                $table->dropColumn('clinical_record_id');
            });
        }
    }
};
