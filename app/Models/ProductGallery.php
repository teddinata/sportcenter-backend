<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGallery extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id', 'url', 'description'
    ];

    public function getUrlAttribute($url)
    {
        return config('app.url') . Storage::url($url);
    }

    /**
     * Get the product that owns the ProductGallery
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(ProductImage::class, 'product_id', 'id');
    }
}
