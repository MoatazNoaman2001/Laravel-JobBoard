<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use App\Notifications\NewMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{

    public function store(Request $request, $conversationId)
    {
        $request->validate([
            'content' => 'required|string|max:5000',
        ]);
        
        $conversation = Conversation::findOrFail($conversationId);
        $user = Auth::user();
        
        if ($conversation->employer_id !== $user->id && $conversation->candidate_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'content' => $request->content,
            'is_read' => false,
        ]);
        
        $conversation->touch();

        $recipientId = ($conversation->employer_id === $user->id) 
            ? $conversation->candidate_id 
            : $conversation->employer_id;
            
        $recipient = ($recipientId === $conversation->candidate_id)
            ? $conversation->candidate
            : $conversation->employer;
        
        // Send notification
        $recipient->notify(new NewMessageNotification($message));
        
        // Broadcast event for real-time updates
        broadcast(new MessageSent($message))->toOthers();
        
        return response()->json([
            'message' => $message->getFormattedData()
        ]);
    }
    
    /**
     * Mark all messages in a conversation as read for the current user.
     */
    public function markAsRead($conversationId)
    {
        $conversation = Conversation::findOrFail($conversationId);
        $user = Auth::user();

        if ($conversation->employer_id !== $user->id && $conversation->candidate_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        $conversation->messages()
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);
        
        return response()->json([
            'success' => true
        ]);
    }
}