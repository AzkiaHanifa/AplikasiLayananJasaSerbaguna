<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    /**
     * Kolom mana saja yang boleh diisi secara massal
     * (Penting untuk Banner::create dan $banner->update)
     */
    protected $fillable = [
        'title',
        'image',
    ];
}