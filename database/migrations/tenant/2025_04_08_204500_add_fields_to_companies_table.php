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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('nit')->nullable(); // RNCEmisor
            $table->renameColumn('name', 'legal_name');
            $table->string('trade_name')->nullable(); // NombreComercial
            $table->string('economic_activity')->nullable(); // ActividadEconomica
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->renameColumn('legal_name', 'name');
            $table->dropColumn(['nit', 'trade_name', 'economic_activity']);
            $table->dropSoftDeletes();
        });
    }
};
