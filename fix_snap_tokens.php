<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

use App\Models\Transaksi;

$fixedCount = 0;
Transaksi::where('metode_bayar', 'non_tunai')
    ->whereNull('snap_token')
    ->get()
    ->each(function($t) use (&$fixedCount) {
        if (!empty($t->catatan)) {
            $t->update([
                'snap_token' => $t->catatan,
                'catatan' => null
            ]);
            $fixedCount++;
        }
    });

echo "Fixed $fixedCount transactions.\n";
