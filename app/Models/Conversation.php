<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'application_id',
        'employer_id',
        'candidate_id'
    ];

    /**
     * Get the application associated with the conversation.
     */
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * Get the employer associated with the conversation.
     */
    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    /**
     * Get the candidate associated with the conversation.
     */
    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    /**
     * Get all messages for this conversation.
     */
    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    /**
     * Get unread messages count for a specific user.
     */
    public function unreadMessagesCount($userId)
    {
        return $this->messages()
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->count();
    }

    /**
     * Get the latest message in the conversation.
     */
    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }
}