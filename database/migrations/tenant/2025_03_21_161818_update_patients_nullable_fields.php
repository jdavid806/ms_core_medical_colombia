<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('first_name')->nullable()->change();
            $table->string('last_name')->nullable()->change();
            $table->string('gender')->nullable()->change();
            $table->string('country_id')->nullable()->change();
            $table->string('department_id')->nullable()->change();
            $table->string('city_id')->nullable()->change();
            $table->string('whatsapp')->nullable()->change();
            $table->unsignedBigInteger('social_security_id')->nullable()->change();
            $table->string('blood_type')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('first_name')->nullable(false)->change();
            $table->string('last_name')->nullable(false)->change();
            $table->string('gender')->nullable(false)->change();
            $table->string('country_id')->nullable(false)->change();
            $table->string('department_id')->nullable(false)->change();
            $table->string('city_id')->nullable(false)->change();
            $table->string('whatsapp')->nullable(false)->change();
            $table->unsignedBigInteger('social_security_id')->nullable(false)->change();
            $table->string('blood_type')->nullable(false)->change();
        });
    }
};
