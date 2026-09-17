<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'is_eco_certified',
        'is_active',
    ];

    /**
     * The seller (user) that owns the product.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Alias for user() relationship.
     */
    public function seller()
    {
        return $this->user();
    }

    /**
     * The category that the product belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * The order items that the product is part of.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * The reviews this product has received.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Get the average rating of the product.
     */
    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }
}
