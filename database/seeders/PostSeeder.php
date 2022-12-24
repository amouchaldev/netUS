<?php

namespace Database\Seeders;

use App\Models\Community;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nbPosts = $this->command->ask('How Many Post You Want To Insert ?');
        $users = User::all();
        $communities = Community::all();
        Post::factory()->count($nbPosts)->make()->each(function ($post) use($users, $communities) {
            $post->author_id = $users->random()->id;
            $post->community_id = $communities->random()->id;
            $post->save();
        });
    }
}
