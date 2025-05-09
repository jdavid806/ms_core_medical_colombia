<?php

use App\Enum\GenderEnum;
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
        Schema::table('users', function (Blueprint $table) {
            $table->string('country_id')->nullable();
            $table->string('city_id')->nullable();
            $table->foreignId('user_specialty_id')->nullable()->change();
            $table->enum('gender', [
                'INDETERMINATE',
                'MALE',
                'FEMALE'
            ])->default('INDETERMINATE');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->jsonb('data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('country_id');
            $table->dropColumn('city_id');
            $table->dropColumn('gender');
            $table->dropColumn('phone');
            $table->dropColumn('email');
            $table->dropColumn('data');
        });
    }
};
