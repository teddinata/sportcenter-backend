<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'size'
    ];

    /**
     * Get all of the products for the Size
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    // public function products()
    // {
    //     return $this->belongsToMany(Product::class, 'product_sizes', 'size_id', 'product_id');
    // }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_sizes')->withPivot('stock');
    }

    // transaction detail
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class, 'size_id', 'id');
    }
}
