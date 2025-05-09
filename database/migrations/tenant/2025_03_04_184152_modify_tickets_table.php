<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::transaction(function () {
            // Eliminar el CHECK constraint existente
            DB::statement('
                ALTER TABLE tickets 
                DROP CONSTRAINT IF EXISTS tickets_reason_check
            ');

            // Crear un nuevo CHECK constraint con el valor adicional
            DB::statement('
                ALTER TABLE tickets 
                ADD CONSTRAINT tickets_reason_check 
                CHECK (reason IN (
                    \'ADMISSION_PRESCHEDULED\',
                    \'CONSULTATION_GENERAL\',
                    \'SPECIALIST\',
                    \'VACCINATION\',
                    \'LABORATORY\',
                    \'EXIT_CONSULTATION\',
                    \'OTHER\'
                ))
            ');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir los cambios en orden inverso
        DB::transaction(function () {
            // Eliminar el nuevo CHECK constraint
            DB::statement('
                ALTER TABLE tickets 
                DROP CONSTRAINT IF EXISTS tickets_reason_check
            ');

            // Restaurar el CHECK constraint original (sin EXIT_CONSULTATION)
            DB::statement('
                ALTER TABLE tickets 
                ADD CONSTRAINT tickets_reason_check 
                CHECK (reason IN (
                    \'ADMISSION_PRESCHEDULED\',
                    \'CONSULTATION_GENERAL\',
                    \'SPECIALIST\',
                    \'VACCINATION\',
                    \'LABORATORY\',
                    \'OTHER\'
                ))
            ');
        });
    }
};
