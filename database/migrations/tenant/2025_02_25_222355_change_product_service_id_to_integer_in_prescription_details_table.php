<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Primero convierte la columna a texto para poder realizar la conversión a entero
        Schema::table('prescription_details', function (Blueprint $table) {
            $table->text('product_service_id')->change();
        });

        // Ahora convierte la columna de texto a entero usando la conversión explícita
        DB::statement('ALTER TABLE prescription_details ALTER COLUMN product_service_id TYPE integer USING (product_service_id::integer);');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Revertir el cambio a texto si es necesario
        DB::statement('ALTER TABLE prescription_details ALTER COLUMN product_service_id TYPE text USING (product_service_id::text);');
    }
};
