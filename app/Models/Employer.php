<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasUuids;
    protected $fillable = [
        'user_id',
        'company_name',
        'description',
        'logo',
        'website',
        'industry',
        'company_size',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
