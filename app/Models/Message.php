<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'content',
        'is_read',
        'read_at'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime'
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->is_read = true;
            $this->read_at = now();
            $this->save();
        }
        
        return $this;
    }


    public function getFormattedData()
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'sender_id' => $this->sender_id,
            'sender_name' => $this->sender->name,
            'is_read' => $this->is_read,
            'created_at' => $this->created_at->diffForHumans(),
            'timestamp' => $this->created_at->toIso8601String(),
        ];
    }
}