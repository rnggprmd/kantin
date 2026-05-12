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
        Schema::table('transaksis', function (Blueprint $table) {
            if (!Schema::hasColumn('transaksis', 'meja_id')) {
                $table->foreignId('meja_id')->nullable()->constrained('mejas')->onDelete('set null');
            }
            if (!Schema::hasColumn('transaksis', 'nomor_antrean')) {
                $table->string('nomor_antrean')->nullable();
            }
            if (!Schema::hasColumn('transaksis', 'status_pesanan')) {
                $table->string('status_pesanan')->default('menunggu');
            }
        });
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropForeign(['meja_id']);
            $table->dropColumn(['meja_id', 'nomor_antrean', 'status_pesanan']);
        });
    }
};
