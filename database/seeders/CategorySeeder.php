<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Samsung Galaxy S', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Samsung Galaxy A', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Samsung Galaxy M', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Samsung Galaxy Z', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Phụ kiện',         'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Đồng hồ',          'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Màn hình',          'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Gia dụng',         'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}