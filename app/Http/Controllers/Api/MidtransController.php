<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    public function callback(Request $request) {
        $serverKey = config('midtrans.serverKey'); // Pastikan ini 'server_key' bukan 'serverKey' jika di config file pakai underscore

        $stringToHash = $request->order_id . $request->status_code . $request->gross_amount . $serverKey;
        $calculatedHashedKey = hash('sha512', $stringToHash);

        // --- DEBUGGING START ---
        // Jika validasi signature key gagal, kembalikan detail untuk debugging
        if ($calculatedHashedKey !== $request->signature_key) {
            return response()->json([
                'message' => 'Invalid signature key. Debug Info:',
                'request_signature_key' => $request->signature_key,
                'calculated_signature_key' => $calculatedHashedKey,
                'order_id_from_request' => $request->order_id,
                'status_code_from_request' => $request->status_code,
                'gross_amount_from_request' => $request->gross_amount,
                'server_key_from_config' => $serverKey,
                'string_to_hash' => $stringToHash
            ], 401);
        }
        // --- DEBUGGING END ---


        $transactionStatus = $request->transaction_status;
        $orderId = $request->order_id;
        $transaction = Transaksi::where('kode', $orderId)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        switch ($transactionStatus) {
            case 'capture':
                if ($request->payment_type == 'credit_card') {
                    if ($request->fraud_status == 'challenge') {
                        $transaction->update(['status_payment' => 'pending']);
                    } else { // fraud_status == 'accept'
                        $transaction->update(['status_payment' => 'dibayar']);
                        foreach ($transaction->transaksiPessenger as $passenger) {
                            $passenger->kursi->update(['is_available' => false]);
                        }
                    }
                } else {
                    $transaction->update(['status_payment' => 'dibayar']);
                    foreach ($transaction->transaksiPessenger as $passenger) {
                        $passenger->kursi->update(['is_available' => false]);
                    }
                }
                break;
            case 'settlement':
                $transaction->update(['status_payment' => 'dibayar']);
                foreach ($transaction->transaksiPessenger as $passenger) {
                    $passenger->kursi->update(['is_available' => false]);
                }
                break;
            case 'pending':
                $transaction->update(['status_payment' => 'pending']);
                break;
            case 'deny':
            case 'expire':
            case 'cancel':
                $transaction->update(['status_payment' => 'gagal']);
                break;
            default:
                $transaction->update(['status_payment' => 'gagal']);
                break;
        }

        return response()->json(['message' => 'Callback processed successfully'], 200);
    }
}
