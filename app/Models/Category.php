<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function jobs()
{
    return $this->belongsToMany(Job::class, 'job_category', 'category_id', 'job_id');
}

}
