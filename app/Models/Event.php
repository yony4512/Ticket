<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'description',
        'location',
        'event_date',
        'image_path',
        'price',
        'capacity',
        'status',
        'user_id'
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'price' => 'decimal:2'
    ];

    public static function categories()
    {
        return [
            'cultura' => 'Cultura y Tradiciones',
            'turismo' => 'Turismo y Naturaleza',
            'arte' => 'Arte y Espectáculos',
            'gastronomia' => 'Gastronomía',
            'educacion' => 'Educación y Talleres',
            'deportes' => 'Deportes y Aventura',
            'nocturna' => 'Vida Nocturna y Entretenimiento',
            'social' => 'Social y Comunitario',
            'religioso' => 'Religioso y Espiritual',
            'negocios' => 'Negocios y Tecnología'
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        return null;
    }

    public function getAvailableCapacityAttribute()
    {
        if (!$this->capacity) {
            return null; // Sin límite de capacidad
        }
        
        $soldTickets = $this->tickets()
            ->whereIn('status', ['pending', 'confirmed'])
            ->sum('quantity');
            
        return max(0, $this->capacity - $soldTickets);
    }

    public function isSoldOut()
    {
        if (!$this->capacity) {
            return false;
        }
        
        return $this->available_capacity <= 0;
    }

    public function canPurchase($quantity = 1)
    {
        if ($this->isSoldOut()) {
            return false;
        }
        
        if (!$this->capacity) {
            return true;
        }
        
        return $this->available_capacity >= $quantity;
    }

    public function getFormattedDateAttribute()
    {
        return $this->event_date->format('d/m/Y H:i');
    }

    public function getDateAttribute()
    {
        return $this->event_date;
    }

    public function getFormattedPriceAttribute()
    {
        return 'S/. ' . number_format($this->price, 2);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>', now());
    }

    public function scopePast($query)
    {
        return $query->where('event_date', '<', now());
    }
}
