<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use Midtrans\Config;
use Midtrans\Notification;
use App\Models\PendaftaranProgram;
use App\Mail\InvoicePendaftaranMail;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        $json = $request->getContent();
        $data = json_decode($json, true);

        // Validasi signature Midtrans
        $serverKey = config('midtrans.serverKey');
        $signatureKey = $request->header('X-Signature') ?? $request->signature_key ?? '';

        $hashed = hash('sha512',
            $data['order_id'] .
            $data['status_code'] .
            $data['gross_amount'] .
            $serverKey
        );

        if ($signatureKey !== $hashed) {
            Log::warning('Signature Midtrans tidak valid', ['signatureKey' => $signatureKey, 'hashed' => $hashed]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Gunakan Notification Midtrans
        $notification = new Notification();

        $transactionStatus = $notification->transaction_status;
        $paymentType = $notification->payment_type;
        $fraudStatus = $notification->fraud_status;
        $orderId = $notification->order_id;

        // Ambil ID dari order_id
        $id = str_replace('ORDER-', '', $orderId);
        $pendaftaran = PendaftaranProgram::with('user', 'program')->find($id);

        if (!$pendaftaran) {
            Log::warning('PendaftaranProgram tidak ditemukan', ['order_id' => $orderId]);
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Default: tidak kirim email
        $kirimInvoice = false;

        // Update status berdasarkan Midtrans
        if ($transactionStatus == 'capture') {
            if ($paymentType == 'credit_card') {
                if ($fraudStatus == 'challenge') {
                    $pendaftaran->status = 'menunggu';
                } else {
                    $pendaftaran->status = 'diterima';
                    $kirimInvoice = true;
                }
            }
        } elseif ($transactionStatus == 'settlement') {
            $pendaftaran->status = 'diterima';
            $kirimInvoice = true;
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $pendaftaran->status = 'ditolak';
        } elseif ($transactionStatus == 'pending') {
            $pendaftaran->status = 'menunggu';
        }

        $pendaftaran->save();

        // Kirim email invoice hanya jika status diterima
        if ($kirimInvoice && $pendaftaran->user && $pendaftaran->user->email) {
            Mail::to($pendaftaran->user->email)->send(new InvoicePendaftaranMail($pendaftaran));
            Log::info('Email invoice berhasil dikirim ke: ' . $pendaftaran->user->email);
        }

        Log::info('Webhook Midtrans diterima dan status diperbarui', [
            'order_id' => $orderId,
            'status' => $pendaftaran->status,
            'transaction_status' => $transactionStatus,
        ]);

        return response()->json(['message' => 'Notifikasi diproses']);
    }
}
