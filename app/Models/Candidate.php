<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasUuids;
    protected $fillable = [
        'user_id',
        'resume',
        'skills',
        'experience',
        'phone',
        'current_position',
        'education',
    ];

    protected $casts = [
        'skills' => 'array',
        'experience' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
