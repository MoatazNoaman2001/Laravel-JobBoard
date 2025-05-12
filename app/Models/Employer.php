<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{

    protected $fillable = [
        'user_id',
        'company_name',
        'description',
        'logo',
        'website',
        'industry',
        'company_size',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
