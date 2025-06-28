<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public static function admin()
    {
        return static::where('name', 'admin')->first();
    }

    public static function user()
    {
        return static::where('name', 'user')->first();
    }

    public function hasPermission($permission)
    {
        // Por ahora, los administradores tienen todos los permisos
        return $this->name === 'admin';
    }
} 