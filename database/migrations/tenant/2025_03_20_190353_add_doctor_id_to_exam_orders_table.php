<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('exam_orders', function (Blueprint $table) {
            $table->foreignId('doctor_id')->nullable()->constrained('users')->onDelete('SET NULL');
        });
    }

    public function down()
    {
        Schema::table('exam_orders', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']);
            $table->dropColumn('doctor_id');
        });
    }
};
