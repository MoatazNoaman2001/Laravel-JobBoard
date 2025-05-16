<?php

namespace App\Http\Controllers;


use App\Events\MessageSent;
use App\Models\Application;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Notifications\NewMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $userType = $user->user_type;
        
        if ($userType === 'employer') {
            $conversations = Conversation::where('employer_id', $user->id)
                ->with(['candidate:id,name', 'application', 'latestMessage'])
                ->get()
                ->map(function ($conversation) use ($user) {
                    return [
                        'id' => $conversation->id,
                        'application_id' => $conversation->application_id,
                        'job_title' => $conversation->application->job->title,
                        'participant' => $conversation->candidate->name,
                        'participant_id' => $conversation->candidate_id,
                        'unread_count' => $conversation->unreadMessagesCount($user->id),
                        'latest_message' => $conversation->latestMessage ? [
                            'content' => $conversation->latestMessage->content,
                            'created_at' => $conversation->latestMessage->created_at->diffForHumans(),
                        ] : null,
                        'updated_at' => $conversation->updated_at,
                    ];
                })
                ->sortByDesc('updated_at')
                ->values();
        } else {
            $conversations = Conversation::where('candidate_id', $user->id)
                ->with(['employer:id,name', 'application', 'latestMessage'])
                ->get()
                ->map(function ($conversation) use ($user) {
                    return [
                        'id' => $conversation->id,
                        'application_id' => $conversation->application_id,
                        'job_title' => $conversation->application->job->title,
                        'participant' => $conversation->employer->name,
                        'participant_id' => $conversation->employer_id,
                        'unread_count' => $conversation->unreadMessagesCount($user->id),
                        'latest_message' => $conversation->latestMessage ? [
                            'content' => $conversation->latestMessage->content,
                            'created_at' => $conversation->latestMessage->created_at->diffForHumans(),
                        ] : null,
                        'updated_at' => $conversation->updated_at,
                    ];
                })
                ->sortByDesc('updated_at')
                ->values();
        }
        
        return response()->json([
            'conversations' => $conversations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(conversation $conversation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(conversation $conversation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, conversation $conversation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(conversation $conversation)
    {
        //
    }
}
