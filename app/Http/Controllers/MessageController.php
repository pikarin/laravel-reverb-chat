<?php

namespace App\Http\Controllers;

use App\Jobs\SendMessage;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(): JsonResponse
    {
        $messages = Message::with('user')->get()->append('time');

        return response()->json($messages);
    }

    public function store(Request $request): JsonResponse
    {
        $message = Message::create([
            'user_id' => auth()->id(),
            'body' => $request->input('text'),
        ]);

        SendMessage::dispatch($message);

        return response()->json([
            'success' => true,
            'message' => 'Message created and job dispatched.',
        ]);
    }
}
