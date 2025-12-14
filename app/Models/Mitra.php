<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;

    protected $table = 'mitra';
    protected $guarded = ['id'];
    protected $fillable = [
        'user_id',
        'nik',
        'alamat',
        'foto_ktp',
        'status',
    ];

    // Relasi: Mitra milik satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}