<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('companies');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('office_id')->constrained('offices')->onDelete('cascade');
            $table->string('legal_name');
            $table->string('nit')->unique();
            $table->foreignId('legal_representative_id')->constrained('people');
        });
    }
};
