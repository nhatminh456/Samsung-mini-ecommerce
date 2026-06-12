<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'color',
        'storage',
        'price',
        'stock_quantity',
        'sku'
    ];

    // Biến thể này thuộc về 1 Sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Biến thể này có nhiều ảnh
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'variant_id');
    }
}