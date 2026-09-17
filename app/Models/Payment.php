<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'method',
        'status',
        'amount',
        'mercado_pago_id',
        'transaction_id',
        'metadata',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'metadata' => 'json',
    ];

    /**
     * Relación con Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Verificar si el pago está completado
     */
    public function isPaid()
    {
        return $this->status === 'completed';
    }

    /**
     * Marcar como pagado
     */
    public function markAsPaid($transactionId = null)
    {
        $this->update([
            'status' => 'completed',
            'transaction_id' => $transactionId,
            'paid_at' => now(),
        ]);
    }

    /**
     * Marcar como fallido
     */
    public function markAsFailed($reason = null)
    {
        $this->update([
            'status' => 'failed',
            'metadata' => array_merge($this->metadata ?? [], ['failed_reason' => $reason]),
        ]);
    }
}
