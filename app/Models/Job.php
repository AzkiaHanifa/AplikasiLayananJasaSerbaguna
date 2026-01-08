<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
     protected $fillable = [
        'user_id',
        'title', 
        'company',
        'job_image',
        'description',
        'type',
        'is_job',
        'location',
        'is_active',
        'category_id', // JANGAN LUPA DITAMBAHKAN
    ];
   public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
