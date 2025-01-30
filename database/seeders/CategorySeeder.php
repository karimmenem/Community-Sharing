<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
{
    $categories = [
        'Technology',
        'Science',
        'Health',
        'Education',
        'Travel',
        'Food',
        'Sports',
        'Entertainment',
        'Business',
        'Art',
    ];

    foreach ($categories as $category) {
        Category::firstOrCreate(['name' => $category]);
    }
}

}