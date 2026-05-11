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
        Config::$isSanitized = (bool) config('services.midtrans.is_sanitized');
        Config::$is3ds = (bool) config('services.midtrans.is_3ds');

        try {
            $notification = new Notification();

            $transactionStatus = $notification->transaction_status;
            $orderId = $notification->order_id;
            $statusCode = $notification->status_code;
            $grossAmount = $notification->gross_amount;
            $serverKey = config('services.midtrans.server_key');

            // Verify signature key to prevent spoofing
            // SHA512(order_id + status_code + gross_amount + ServerKey)
            $signature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

            if ($signature !== $notification->signature_key) {
                return response()->json(['status' => 'error', 'message' => 'Invalid signature'], 403);
            }

            // Extract real transaction code
            $transactionCode = explode('-', $orderId)[0];
            $transaksi = Transaksi::where('kode_transaksi', $transactionCode)->first();

            if (!$transaksi) {
                return response()->json(['status' => 'error', 'message' => 'Transaksi tidak ditemukan'], 404);
            }

            if ($transactionStatus == 'capture') {
                if ($notification->fraud_status == 'challenge') {
                    $transaksi->update(['status' => 'pending']);
                } else {
                    $transaksi->update(['status' => 'selesai']);
                }
            } else if ($transactionStatus == 'settlement') {
                $transaksi->update(['status' => 'selesai']);
            } else if ($transactionStatus == 'pending') {
                $transaksi->update(['status' => 'pending']);
            } else if ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                // Return stock to inventory if it wasn't already canceled
                if ($transaksi->status !== 'batal') {
                    $transaksi->restoreStock();
                    $transaksi->update(['status' => 'batal']);
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Notification processed'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
