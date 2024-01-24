<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::truncate();
        Product::create([
            'name' => 'Product 1',
            'price' => 10,
            'description' => 'This is the first sample product.',
            'teg_id' => 1,
            'brand_id' => 1,
            'condition_id' => 1,
        ]);

    }
}
