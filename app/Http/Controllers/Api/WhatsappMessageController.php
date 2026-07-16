<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WhatsappMessage;
use Illuminate\Support\Facades\DB;

class WhatsappMessageController extends Controller
{
    /**
     * Get all messages untuk transaksi tertentu
     */
    public function getByTransaksi($transaksi_id)
    {
        $messages = WhatsappMessage::where('transaksi_id', $transaksi_id)
            ->select('id', 'target_number', 'status', 'message', 'status_updated_at', 'failure_reason')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $messages
        ]);
    }

    /**
     * Get status summary untuk transaksi
     */
    public function getStatusSummary($transaksi_id)
    {
        $messages = WhatsappMessage::where('transaksi_id', $transaksi_id)
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        $summary = [
            'pending' => $messages->get('pending')->count ?? 0,
            'sent' => $messages->get('sent')->count ?? 0,
            'delivered' => $messages->get('delivered')->count ?? 0,
            'read' => $messages->get('read')->count ?? 0,
            'failed' => $messages->get('failed')->count ?? 0,
        ];

        return response()->json([
            'success' => true,
            'transaksi_id' => $transaksi_id,
            'summary' => $summary
        ]);
    }

    /**
     * Get detail satu pesan
     */
    public function show($message_id)
    {
        $message = WhatsappMessage::find($message_id);

        if (!$message) {
            return response()->json([
                'success' => false,
                'message' => 'Message not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $message
        ]);
    }
}
