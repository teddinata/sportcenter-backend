<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_category_id', 'name', 'description', 'price', 'stock', 'status', 'tags', 'size',
    ];

    /**
     * Get the productCategory that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }

    /**
     * Get all of the productImages for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function galleries()
    {
        return $this->hasMany(ProductGallery::class, 'product_id', 'id');
    }

    // product sizes pivot
    // public function sizes()
    // {
    //     return $this->belongsToMany(Size::class, 'product_sizes', 'product_id', 'size_id');
    // }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_sizes')->withPivot('stock');
    }
    // product size
    // public function productSizes()
    // {
    //     return $this->hasMany(ProductSize::class, 'product_id', 'id');
    // }
}
