<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('document_type')->nullable()->after('name');
            $table->string('document_number')->nullable()->after('document_type');
            $table->string('logo')->nullable()->after('document_number');
            $table->string('watermark')->nullable()->after('logo');
            $table->string('phone')->nullable()->after('watermark');
            $table->string('email')->nullable()->after('phone');
            $table->string('address')->nullable()->after('email');
            $table->string('country')->nullable()->after('address');
            $table->string('province')->nullable()->after('country');
            $table->string('city')->nullable()->after('province');
        });

        Schema::dropIfExists('offices');
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('assets');
    }

    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn([
                'document_type', 'document_number', 'logo', 'watermark',
                'phone', 'email', 'address', 'country', 'province', 'city'
            ]);
        });

        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('address');
            $table->timestamps();
        });

        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->timestamps();
        });

        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->decimal('value', 10, 2);
            $table->timestamps();
        });
    }
};
