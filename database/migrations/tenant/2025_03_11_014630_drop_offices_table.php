<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('persona_naturals', function (Blueprint $table) {
            $table->dropForeign(['office_id']);
        });

        Schema::table('sucursals', function (Blueprint $table) {
            $table->dropForeign(['office_id']);
        });

        Schema::dropIfExists('offices');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->string('commercial_name');
            $table->string('email')->unique();
            $table->string('whatsapp')->unique();
            $table->foreignId('country_id')->constrained('countries');
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('city_id')->constrained('cities');
            $table->string('address');
            $table->string('logo')->nullable();
            $table->enum('type', ['natural', 'legal']);
            $table->timestamps();
            $table->boolean('active')->default(true);
        });

        Schema::table('persona_naturals', function (Blueprint $table) {
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
        });

        Schema::table('sucursals', function (Blueprint $table) {
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
        });
    }
};
