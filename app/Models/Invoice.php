<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoice';

    protected $fillable = [
        'transaksi_jasa_id',
        'invoice_number',
        'tipe_invoice',
        'subtotal',
        'diskon',
        'total',
        'metode_pembayaran',
        'status',
        'keterangan',
        'bukti_pembayaran',
        'jatuh_tempo',
        'dibayar_pada',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'diskon' => 'decimal:2',
        'total' => 'decimal:2',
        'jatuh_tempo' => 'datetime',
        'dibayar_pada' => 'datetime',
    ];

    /**
     * Relasi: Invoice milik satu Transaksi Jasa
     */
    public function transaksi()
    {
        return $this->belongsTo(TransaksiJasa::class, 'transaksi_jasa_id');
    }

    /**
     * Relasi: Invoice punya banyak item
     */
    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    /**
     * Scope invoice yang belum dibayar
     */
    public function scopeBelumDibayar($query)
    {
        return $query->whereIn('status', ['draft', 'menunggu_pembayaran']);
    }

    /**
     * Scope invoice sudah dibayar
     */
    public function scopeSudahDibayar($query)
    {
        return $query->where('status', 'dibayar');
    }
}
