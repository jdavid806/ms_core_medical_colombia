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
        Schema::table('user_absences', function (Blueprint $table) {
            $table->dropColumn('date');
            $table->date('start_date')->after('user_id')->nullable();
            $table->date('end_date')->after('start_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_absences', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'end_date']);
            $table->date('date')->after('user_id');
        });
    }
};
