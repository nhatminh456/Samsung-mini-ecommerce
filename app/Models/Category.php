<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Cho phép insert dữ liệu hàng loạt vào các cột này
    protected $fillable = ['name'];

    // Mối quan hệ 1-N: 1 Danh mục có NHIỀU Sản phẩm
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getTenDMAttribute()
    {
        return $this->name;
    }
}
