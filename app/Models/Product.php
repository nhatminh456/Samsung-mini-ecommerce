<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';



    protected $fillable = [
        'category_id', 
        'name',        
        'description', 
        'specifications', 
        'release_year',   
        'is_bestseller'   
    ];

    // ==========================================
    // 1. CÁC MỐI QUAN HỆ (RELATIONSHIPS)
    // ==========================================

    public function category()
    {
        // Sửa lại khóa ngoại thành category_id
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    

    // Lấy giá hiển thị (Lấy giá của biến thể đầu tiên)
    public function getPriceAttribute()
    {
        $firstVariant = $this->variants->first();
        return $firstVariant ? $firstVariant->price : 0;
    }

    // Lấy số lượng kho (Tổng kho của tất cả biến thể)
    public function getStockQuantityAttribute()
    {
        return $this->variants->sum('stock_quantity');
    }

    // Lấy ảnh đại diện (Lấy tấm ảnh đầu tiên trong bộ sưu tập)
    public function getImageUrlAttribute()
    {
        $firstImage = $this->images->first();

        if (!$firstImage) {
            return 'images/default.jpg';
        }

        $imagePath = $firstImage->image_path;

        if (str_starts_with($imagePath, 'http') || str_starts_with($imagePath, 'https') || str_starts_with($imagePath, 'data:image')) {
            return $imagePath;
        }

        return 'images/' . $imagePath;
    }

    public function getCategoryNameAttribute()
    {
        return $this->category ? $this->category->name : 'Chưa xác định';
    }
}