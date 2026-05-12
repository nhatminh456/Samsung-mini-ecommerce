<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products'; // Tên bảng

    // Khai báo khóa chính là chuỗi, không tự tăng
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    // Tắt timestamps vì bảng không có created_at/updated_at
    public $timestamps = false;

    protected $fillable = [
        'id',
        'tenSP',
        'gia',
        'categoryID',
        'image',
        'mota',
        'namSX',
        'thongso',
        'bestSeller',
        'stock_quantity'
    ];

    // Tạo Accessor để code Controller cũ ($product->name, $product->price) vẫn chạy được mượt mà
    public function getNameAttribute()
    {
        return $this->tenSP;
    }

    public function getPriceAttribute()
    {
        return $this->gia;
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'images/default.jpg';
        }
        if (str_starts_with($this->image, 'http') || str_starts_with($this->image, 'https') || str_starts_with($this->image, 'data:image')) {
            return $this->image;
        }
        return 'images/' . $this->image;
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryID', 'id');
    }

    public function getCategoryNameAttribute()
    {
        return $this->category ? $this->category->name : 'Chưa xác định';
    }
}
