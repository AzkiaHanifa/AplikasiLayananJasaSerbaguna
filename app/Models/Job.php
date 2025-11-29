<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
     protected $fillable = [
        'title', 
        'company',
        'description',
        'type',
        'location',
        'is_active',
        'category_id', // JANGAN LUPA DITAMBAHKAN
    ];
   public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
