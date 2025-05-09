<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('document_type')->nullable()->change(); // Hace que 'document_type' sea nullable
            $table->string('document_number')->nullable()->change(); // Hace que 'document_number' sea nullable
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('document_type')->nullable(false)->change(); // Revierte el campo a no nullable
            $table->string('document_number')->nullable(false)->change(); // Revierte el campo a no nullable
        });
    }
};
