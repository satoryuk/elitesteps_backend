<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'product_id';
    
    protected $fillable = [
        'product_name',
        'description',
        'price',
        'discount',
        'stock',
        'type_id',
        'brand_id',
        'image',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'emial_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    // Relationships
    public function type()
    {
        return $this->belongsTo(type::class, 'type_id', 'type_id');
    }
    
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'brand_id');
    }
    
    // public function orderItems()
    // {
    //     return $this->hasMany(OrderItem::class, 'product_id', 'product_id');
    // }
    
    // public function inventory()
    // {
    //     return $this->hasOne(Inventory::class, 'product_id', 'product_id');
    // }

     /**
     * Get the identifier that will be stored in the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key-value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
