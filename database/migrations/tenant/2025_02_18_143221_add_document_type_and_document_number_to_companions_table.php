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
        Schema::table('companions', function (Blueprint $table) {
            $table->string('document_type');
            $table->string('document_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companions', function (Blueprint $table) {
            $table->dropColumn('document_type');
            $table->dropColumn('document_number');
        });
    }
};
