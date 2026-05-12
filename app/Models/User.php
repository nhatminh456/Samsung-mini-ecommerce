<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    // Khai báo khóa chính là chuỗi
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'email',
        'password',
        'role'
    ];

    // Quan hệ với bảng Orders
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }
}