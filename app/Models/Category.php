<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'icon', 'is_featured'];

    // Satu Kategori memiliki BANYAK Pekerjaan
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
    
}
