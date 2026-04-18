<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Because older enum columns might cause issues with change() depending on DB layer, 
            // the safest cross-platform way without doctrine/dbal requirement in older laravel 
            // is raw DB statements or simply changing standard string if using Laravel 11.
            $table->string('metode_bayar', 50)->default('tunai')->change();
        });
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->enum('metode_bayar', ['tunai', 'transfer', 'qris'])->default('tunai')->change();
        });
    }
};
