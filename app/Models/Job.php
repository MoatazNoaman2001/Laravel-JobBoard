<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasUuids;
    protected $fillable= [
        'employer_id',
        'title',
        'responsibilities',
        'skills',
        'qualifications',
        'salary_range',
        'benefits',
        'location',
        'work_type',
        'application_deadline',
        'logo'
    ];

    protected function cast(): array {
        return [
            'skills' => 'array',
            'qualifications' => 'array',
            'salary_range' => 'array',
            'benefits' => 'array',
            'location' => 'array',
        ];
    }

    public function employer() {
        return $this->belongsTo(Employer::class , 'employer_id');
    }
}
