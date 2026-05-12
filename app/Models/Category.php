<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;

    // Cho phép insert dữ liệu hàng loạt vào các cột này
    protected $fillable = ['id', 'tenDM'];

    // Mối quan hệ 1-N: 1 Danh mục có NHIỀU Sản phẩm
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getNameAttribute()
    {
        return $this->tenDM;
    }
}
