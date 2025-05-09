<?php

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
        Schema::create('integrations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->nullable(); // e.g., 'api_key', 'oauth', 'basic_auth', etc.
            $table->string('status')->default('inactive');
            $table->string('url')->nullable();
            $table->string('auth_type')->nullable(); // 'bearer', 'basic', 'api_key', etc.
            $table->text('auth_config')->nullable(); // JSON con configuraciones específicas
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('integrations');
    }
};
