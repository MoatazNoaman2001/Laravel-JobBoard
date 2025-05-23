<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Job extends Model
{
    use HasUuids;
    use SoftDeletes;
    
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
        'country',
        'experience_level_range',
        'application_deadline',
        'logo'
    ];

    
    protected $dates = ['deleted_at'];

    protected function cast(): array {
        return [
            'skills' => 'array',
            'qualifications' => 'array',
            'salary_range' => 'array',
            'benefits' => 'array',
            'location' => 'array',
            'experience_level_range' => 'array',
            'deleted_at' => 'datetime',
        ];
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function isNew(){
        return $this->created_at->diffInDays(now()) <= 30;
    }
    
    public function employer() {
        return $this->belongsTo(Employer::class , 'employer_id');
    }
}
