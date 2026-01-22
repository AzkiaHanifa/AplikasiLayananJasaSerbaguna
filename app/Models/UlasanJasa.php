<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UlasanJasa extends Model
{
    protected $table = 'ulasan_jasa';

    protected $fillable = [
        'transaksi_jasa_id',
        'rating',
        'ulasan',
    ];

    public function transaksi()
    {
        return $this->belongsTo(TransaksiJasa::class, 'transaksi_jasa_id');
    }

    

}

