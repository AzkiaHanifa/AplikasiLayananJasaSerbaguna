<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $table = 'invoice_items';

    protected $fillable = [
        'invoice_id',
        'deskripsi',
        'qty',
        'harga',
        'total',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * Relasi: Item milik satu Invoice
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
