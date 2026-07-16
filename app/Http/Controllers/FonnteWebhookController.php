<?php

namespace App\Http\Controllers;

use App\Models\WhatsappMessage;
use Illuminate\Http\Request;

class FonnteWebhookController extends Controller
{
    public function status(Request $request)
    {
        if (
            $request->token != config('services.fonnte.account_token')
        ) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $messageId = $request->message_id;

        $status = $request->status;

        $reason = $request->reason;

        $message = WhatsappMessage::where(
            'message_id',
            $messageId
        )->first();

        if (!$message) {
            return response()->json([
                'message' => 'Message not found'
            ], 404);
        }

        $message->update([
            'status' => $status,
            'failure_reason' => $reason,
            'status_updated_at' => now(),
        ]);

        return response()->json([
            'success' => true
        ]);
    }
}