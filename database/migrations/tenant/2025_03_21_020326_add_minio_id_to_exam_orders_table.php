<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('exam_orders', function (Blueprint $table) {
            $table->string('minio_id')->nullable()->after('id');
        });
    }

    public function down()
    {
        Schema::table('exam_orders', function (Blueprint $table) {
            $table->dropColumn('minio_id');
        });
    }
};
