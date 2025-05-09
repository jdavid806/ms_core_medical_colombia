<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('companions', function (Blueprint $table) {
            $table->string('first_name')->nullable()->change();
            $table->string('last_name')->nullable()->change();
            $table->string('mobile')->nullable()->change();
            $table->string('document_type')->nullable()->change();
            $table->string('document_number')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('companions', function (Blueprint $table) {
            $table->string('first_name')->nullable(false)->change();
            $table->string('last_name')->nullable(false)->change();
            $table->string('mobile')->nullable(false)->change();
            $table->string('document_type')->nullable(false)->change();
            $table->string('document_number')->nullable(false)->change();
        });
    }
};
