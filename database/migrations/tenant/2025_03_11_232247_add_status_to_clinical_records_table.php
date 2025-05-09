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
        Schema::table('clinical_records', function (Blueprint $table) {
            $table->enum('status', [
                'cancellation_request_pending', 
                'cancellation_request_rejected', 
                'cancellation_request_approved'
            ])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clinical_records', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
