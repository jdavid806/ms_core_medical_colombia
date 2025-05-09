<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('recipes', function (Blueprint $table) {
        $table->enum('status', [
            'PENDING',
            'VALIDATED',
            'DELIVERED',
            'PARTIALLY_DELIVERED',
            'REJECTED'
        ])->default('PENDING')->after('appointment_id'); // o después de otro campo si lo prefieres
    });
}

    
    public function down()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
    
};
