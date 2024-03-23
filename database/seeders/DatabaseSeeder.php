<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
//            BrandSeeder::class,
            StatusSeeder::class,
//            BannersSeeder::class,
//            AttributeSeeder::class,
//            ProductsTableSeeder::class,
            // ConditionSeeder::class,
        ]);

    }
}
