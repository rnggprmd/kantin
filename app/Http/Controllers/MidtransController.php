<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = (bool) config('services.midtrans.is_production');

        $notification = new Notification();

        $orderIdParts = explode('-', $notification->order_id);
        $kodeTransaksi = $orderIdParts[0];

        $transaksi = Transaksi::where('kode_transaksi', $kodeTransaksi)->firstOrFail();

        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status ?? null;

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'accept') {
                $transaksi->update(['status' => 'selesai']);
            }
        } elseif ($transactionStatus == 'settlement') {
            $transaksi->update(['status' => 'selesai']);
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $transaksi->update(['status' => 'batal']);
        } elseif ($transactionStatus == 'pending') {
            // Keep as pending
        }

        return response()->json(['status' => 'success']);
    }
}
