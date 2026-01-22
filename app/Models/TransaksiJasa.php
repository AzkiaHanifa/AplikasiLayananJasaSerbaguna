<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class TransaksiJasa extends Model
{
    use HasFactory;

    protected $table = 'transaksi_jasa';
    protected $guarded = ['id'];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ulasan()
    {
        return $this->hasOne(UlasanJasa::class, 'transaksi_jasa_id');
    }
    

    /**
     * Relasi: 1 Transaksi Jasa punya banyak Invoice
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'transaksi_jasa_id');
    }

    /**
     * Ambil invoice aktif (belum dibayar / menunggu)
     */
    public function invoiceAktif()
    {
        return $this->hasOne(Invoice::class, 'transaksi_jasa_id')
            ->whereIn('status', ['draft', 'menunggu_pembayaran'])
            ->latest();
    }

    /**
     * Total pembayaran yang sudah dibayar
     */
    public function totalDibayar()
    {
        return $this->hasMany(Invoice::class, 'transaksi_jasa_id')
            ->where('status', 'dibayar')
            ->sum('total');
    }
}