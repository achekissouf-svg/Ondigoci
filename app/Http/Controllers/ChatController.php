<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // Get unique users that the current user has chatted with
        $contacts = User::whereIn('id', function($query) use ($userId) {
            $query->select('sender_id')->from('messages')->where('receiver_id', $userId)
                  ->union(
                      $query->newQuery()->select('receiver_id')->from('messages')->where('sender_id', $userId)
                  );
        })->get();

        return view('chat.index', compact('contacts'));
    }

    public function show($receiverId)
    {
        $receiver = User::findOrFail($receiverId);
        $senderId = Auth::id();

        $messages = Message::where(function($q) use ($senderId, $receiverId) {
            $q->where('sender_id', $senderId)->where('receiver_id', $receiverId);
        })->orWhere(function($q) use ($senderId, $receiverId) {
            $q->where('sender_id', $receiverId)->where('receiver_id', $senderId);
        })->orderBy('created_at', 'asc')->get();

        // Mark as read
        Message::where('sender_id', $receiverId)->where('receiver_id', $senderId)->update(['is_read' => true]);

        if (request()->ajax()) {
            return view('chat.partials.messages', compact('messages', 'receiver'))->render();
        }

        return view('chat.show', compact('messages', 'receiver'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string'
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content
        ]);

        return response()->json(['success' => true, 'message' => $message]);
    }
}
