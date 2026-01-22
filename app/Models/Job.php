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

    public function transaksi()
    {
        return $this->hasMany(TransaksiJasa::class, 'job_id');
    }
    public function getRatingAttribute()
    {
        return number_format($this->avg_rating ?? 0, 1);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
