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
         Schema::create('external_products_cache', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('external_id')->unique(); // ID original del microservicio 'admin'

            $table->string('name');
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->decimal('sale_price', 10, 2)->nullable();

            $table->softDeletes(); // fecha de eliminación lógica

            $table->timestamp('synced_at')->nullable(); // última vez que fue sincronizado

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_product_caches');
    }
};
