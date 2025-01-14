<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Category, Post, Comment, Vote, Notification};

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed categories
        $categories = ['Technology', 'Science', 'Health', 'Education', 'Art'];
        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }

        // Seed users
        $users = [
            [
                'username' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'Admin',
                'reputationPoints' => 1000,
            ],
            [
                'username' => 'UserOne',
                'email' => 'user1@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'username' => 'UserTwo',
                'email' => 'user2@example.com',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        // Seed posts
        $posts = [
            [
                'user_id' => 2,
                'categoryId' => 1,
                'title' => 'The Future of AI',
                'description' => 'Exploring the possibilities of artificial intelligence.',
            ],
            [
                'user_id' => 3,
                'categoryId' => 2,
                'title' => 'Space Exploration',
                'description' => 'Advances in technology for space missions.',
            ],
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }

        // Seed comments
        $comments = [
            [
                'post_id' => 1,
                'user_id' => 3,
                'content' => 'This is a fascinating topic! Looking forward to more updates.',
            ],
            [
                'post_id' => 2,
                'user_id' => 2,
                'content' => 'Great insights on space technology.',
            ],
        ];

        foreach ($comments as $comment) {
            Comment::create($comment);
        }

        // Seed votes
        $votes = [
            [
                'post_id' => 1,
                'user_id' => 3,
                'vote_type' => true,
            ],
            [
                'post_id' => 2,
                'user_id' => 2,
                'vote_type' => false,
            ],
        ];

        foreach ($votes as $vote) {
            Vote::create($vote);
        }

        // Seed notifications
        $notifications = [
            [
                'user_id' => 2,
                'message' => 'Your post has received a new comment.',
                'is_read' => false,
            ],
            [
                'user_id' => 3,
                'message' => 'Your comment has been upvoted.',
                'is_read' => true,
            ],
        ];

        foreach ($notifications as $notification) {
            Notification::create($notification);
        }
    }
}
