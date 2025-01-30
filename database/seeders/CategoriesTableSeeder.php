<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Bug Fixes',
            'Best Practices',
            'New Ideas',
            'Tutorials',
            'Q&A',
            'Announcements',
            'Feedback',
            'Off-Topic',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
            ]);
        }
    }
}
