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
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('payer_email')->nullable()->after('payer_name');
            $table->string('payer_phone')->nullable()->after('payer_email');
            $table->string('payment_proof_path')->nullable()->after('notes');
            $table->string('payment_proof_original_name')->nullable()->after('payment_proof_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'payer_email',
                'payer_phone',
                'payment_proof_path',
                'payment_proof_original_name',
            ]);
        });
    }
};
