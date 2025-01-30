<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Create 10 categories
        for ($i = 1; $i <= 10; $i++) {
            Category::create([
                'name' => 'Category ' . $i,
            ]);
        }
    }
}