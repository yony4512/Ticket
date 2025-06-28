<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'from_user_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'to_user_id');
    }

    public function unreadMessages()
    {
        return $this->hasMany(Message::class, 'to_user_id')->whereNull('read_at');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function unreadNotifications()
    {
        return $this->hasMany(Notification::class)->unread();
    }

    public function readNotifications()
    {
        return $this->hasMany(Notification::class)->read();
    }

    public function getActiveTicketsCountAttribute()
    {
        return $this->tickets()
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();
    }

    public function getTotalSpentAttribute()
    {
        return $this->tickets()
            ->whereIn('status', ['confirmed', 'used'])
            ->sum('total_price');
    }

    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles()->where('roles.name', $role)->exists();
        }
        return $this->roles()->where('roles.id', $role->id)->exists();
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
        }
        
        if ($role && !$this->hasRole($role)) {
            $this->roles()->attach($role);
        }
    }

    public function removeRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
        }
        
        if ($role) {
            $this->roles()->detach($role);
        }
    }
}
