<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nbComment = $this->command->ask('How Many Comment You Want To Insert ?');
        $users = User::all();
        $posts = Post::all();

        Comment::factory()
        ->count($nbComment)
        ->make()
        ->each(function ($comment) use($users, $posts) {
            $comment->user_id = $users->random()->id;
            $comment->post_id = $posts->random()->id;
            $comment->save();
        });
        }
}
