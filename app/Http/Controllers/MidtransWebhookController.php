<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\PendaftaranProgram;
use App\Mail\InvoicePendaftaranMail;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $serverKey = config('midtrans.serverKey');
        $json = $request->getContent();
        $data = json_decode($json, true);

        $signatureKey = $request->header('X-Signature') ?? $data['signature_key'] ?? '';

        // Validasi signature
        $hashed = hash('sha512',
            $data['order_id'] .
            $data['status_code'] .
            $data['gross_amount'] .
            $serverKey
        );

        if ($signatureKey !== $hashed) {
            Log::warning('❌ Signature tidak valid');
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Ambil ID dari order_id (format: ORDER-1)
        $orderId = $data['order_id'];
        $id = str_replace('ORDER-', '', $orderId);
        $pendaftaran = PendaftaranProgram::with('user', 'program')->find($id);

        if (!$pendaftaran) {
            Log::warning('❌ Pendaftaran tidak ditemukan', ['order_id' => $orderId]);
            return response()->json(['message' => 'Pendaftaran tidak ditemukan'], 404);
        }

        $transactionStatus = $data['transaction_status'];

        // Update status pembayaran
        if ($transactionStatus === 'settlement') {
            $pendaftaran->status = 'diterima';
            $pendaftaran->save();

            // Kirim email invoice
            try {
                if ($pendaftaran->user && $pendaftaran->user->email) {
                    Mail::to($pendaftaran->user->email)->send(new InvoicePendaftaranMail($pendaftaran));
                    Log::info('✅ Invoice berhasil dikirim ke email', [
                        'email' => $pendaftaran->user->email
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('❌ Gagal mengirim email invoice: ' . $e->getMessage());
            }

        } elseif ($transactionStatus === 'pending') {
            $pendaftaran->status = 'menunggu';
            $pendaftaran->save();
        } elseif ($transactionStatus === 'expire') {
            $pendaftaran->status = 'ditolak';
            $pendaftaran->save();
        } elseif ($transactionStatus === 'cancel') {
            $pendaftaran->status = 'ditolak';
            $pendaftaran->save();
        } elseif ($transactionStatus === 'deny') {
            $pendaftaran->status = 'ditolak';
            $pendaftaran->save();
        } elseif ($transactionStatus === 'capture') {
            // Tambahan opsional jika menggunakan credit card
            if (($data['payment_type'] ?? '') === 'credit_card') {
                if (($data['fraud_status'] ?? '') === 'challenge') {
                    $pendaftaran->status = 'menunggu';
                } else {
                    $pendaftaran->status = 'diterima';
                }
                $pendaftaran->save();
            }
        }

        Log::info('✅ Webhook diterima dan status diperbarui', [
            'order_id' => $orderId,
            'status' => $pendaftaran->status,
            'transaction_status' => $transactionStatus,
        ]);

        return response()->json(['message' => 'Success']);
    }
}
