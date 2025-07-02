<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'transaction_time',
        'midtrans_transaction_id',
        'midtrans_order_id',
        'payment_type',
        'signature_key',
        'amount',
        'status',
        'raw_response',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
    ];

    // Relationship dengan Order (jika ada tabel orders)
    public function order() 
    {
        return $this->belongsTo(Order::class);
    }

    // Accessor untuk format amount
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    // Accessor untuk masked card number (untuk keamanan)
    public function getMaskedCardNumberAttribute()
    {
        if (!$this->card_number) return null;
        
        $cardNumber = str_replace(' ', '', $this->card_number);
        if (strlen($cardNumber) < 8) return $cardNumber;
        
        return substr($cardNumber, 0, 4) . str_repeat('*', strlen($cardNumber) - 8) . substr($cardNumber, -4);
    }

    public function getTransactionId()
    {   
        $order = Order::find($this->order_id);

        $transaction_id = 'QRIS-' . time() . '-' . $order->id;
        return $transaction_id;
    }

    // Scope untuk filter berdasarkan status
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }
}