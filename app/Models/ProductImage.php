<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'variant_id',
        'image_path',
    ];

    // Ảnh thuộc về 1 sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Ảnh thuộc về 1 variant
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}