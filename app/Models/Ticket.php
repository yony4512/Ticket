<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'ticket_code',
        'quantity',
        'total_price',
        'subtotal',
        'commission',
        'payment_method',
        'billing_name',
        'billing_email',
        'billing_address',
        'status',
        'purchased_at',
        'used_at',
        'notes'
    ];

    protected $casts = [
        'purchased_at' => 'datetime',
        'used_at' => 'datetime',
        'total_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'commission' => 'decimal:2'
    ];

    public static function generateTicketCode()
    {
        do {
            $code = 'TIX-' . strtoupper(Str::random(8));
        } while (self::where('ticket_code', $code)->exists());
        
        return $code;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'confirmed' => 'green',
            'cancelled' => 'red',
            'used' => 'blue',
            default => 'gray'
        };
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Pendiente',
            'confirmed' => 'Confirmado',
            'cancelled' => 'Cancelado',
            'used' => 'Usado',
            default => 'Desconocido'
        };
    }

    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'confirmed']) && 
               $this->event->event_date->isFuture();
    }

    public function markAsUsed()
    {
        $this->update([
            'status' => 'used',
            'used_at' => now()
        ]);
    }
} 