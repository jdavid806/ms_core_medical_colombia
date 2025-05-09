<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            // Quitar restricción CHECK para 'document_type'
            DB::statement("ALTER TABLE patients DROP CONSTRAINT IF EXISTS patients_document_type_check");

            // Modificar la columna 'document_type' para que acepte cualquier string
            $table->string('document_type')->change();
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
            // Revertir el cambio en caso de rollback (si es necesario, ajusta la definición original)
            $table->enum('document_type', ['CC', 'CE', 'TI'])->change();

            // Opcional: volver a agregar la restricción CHECK si aplica
            DB::statement("ALTER TABLE patients ADD CONSTRAINT patients_document_type_check CHECK (document_type IN ('CC', 'CE', 'TI'))");
        });
    }
};
