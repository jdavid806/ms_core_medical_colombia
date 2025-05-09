<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropUnique('tickets_ticket_number_unique');
            $table->string('ticket_number')->change();
            $table->foreignId('module_id')->nullable()->constrained('modules');
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('ticket_number')->unique()->change();
        });
    }
};
