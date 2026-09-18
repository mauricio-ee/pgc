<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'bio',
        'phone',
    ];

    /**
     * Get the products published by the user (if seller).
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the orders placed by the user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Helper para comprobar roles
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public const ROLES = [
        'customer',
        'seller',
        'support',
        'order_manager',
        'moderator',
        'farmer_verifier',
        'payment_manager',
        'quality_manager',
        'promotion_manager',
        'analyst',
        'admin',
        'super_admin',
        'technician',
        'certifier',
    ];

    public function isStaff(): bool
    {
        return in_array($this->role, [
            'support',
            'order_manager',
            'moderator',
            'farmer_verifier',
            'payment_manager',
            'quality_manager',
            'promotion_manager',
            'analyst',
            'admin',
            'super_admin',
            'technician',
            'certifier',
        ], true);
    }

    public function isAdmin()
    {
        return in_array($this->role, ['admin', 'super_admin'], true);
    }

    public function isSeller()
    {
        return $this->role === 'seller';
    }

    public function isCertifier()
    {
        return $this->role === 'certifier';
    }

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
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
