<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'types';
    protected $primaryKey = 'type_id';

    protected $fillable = [
        'type_name',
        'category_id',
    ];

    public $timestamps = true;

    /**
     * Get the products associated with the type.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'type_id', 'type_id');
    }

    /**
     * Get the category associated with the type.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }
}
