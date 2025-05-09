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
        Schema::table('admissions', function (Blueprint $table) {
            $table->string('authorization_number')->nullable();
            $table->date('authorization_date')->nullable();
            $table->foreignId('appointment_id')->constrained();
            $table->integer('invoice_id');
            $table->integer('debit_note_id')->nullable();
            $table->integer('credit_note_id')->nullable();
            $table->integer('new_invoice_id')->nullable();
            $table->boolean('copayment')->nullable();
            $table->boolean('moderator_fee')->nullable();
            $table->decimal('billed_amount', 8, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admissions', function (Blueprint $table) {
            $table->dropColumn('authorization_number');
            $table->dropColumn('authorization_date');
            $table->dropForeign(['appointment_id']);
            $table->dropColumn('appointment_id');
            $table->dropForeign(['invoice_id']);
            $table->dropColumn('invoice_id');
            $table->dropForeign(['debit_note_id']);
            $table->dropColumn('debit_note_id');
            $table->dropForeign(['credit_note_id']);
            $table->dropColumn('credit_note_id');
            $table->dropForeign(['new_invoice_id']);
            $table->dropColumn('new_invoice_id');
            $table->dropColumn('copayment');
            $table->dropColumn('moderator_fee');
            $table->dropColumn('billed_amount');
        });
    }
};
