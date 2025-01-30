<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add predefined categories
        Category::firstOrCreate(['name' => 'Technology']);
        Category::firstOrCreate(['name' => 'Health']);
        Category::firstOrCreate(['name' => 'Science']);
        Category::firstOrCreate(['name' => 'Education']);
    }
}
