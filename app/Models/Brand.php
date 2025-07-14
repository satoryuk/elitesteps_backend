<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';

    protected $primaryKey = 'brand_id';

    protected $fillable = [
        'brand_name',
        'description',
        'logo',
    ];

    public $timestamps = true;

    /**
     * Get the products associated with the brand.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id', 'brand_id');
    }
}
