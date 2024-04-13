<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ChurchGroup;
use App\Models\Family;
use App\Models\Member;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::truncate();
        Category::factory()->count(20)->create();

        Post::truncate();
        Post::factory()->count(50)->create();

        $posts = Post::all();
        foreach($posts as $post) {
            $categories = Category::inRandomOrder()->take(rand(1,2));
            $post->categories()->sync($categories->pluck('id'));
        }

        Family::truncate();
        Family::factory()->count(50)->create();

        Member::truncate();
        DB::table('member_church_group')->truncate();
        Member::factory()->count(300)->create();

        $members = Member::all();
        foreach($members as $member) {
            $family = Family::inRandomOrder()->first();
            $member->family_id = $family->id;

            $group = ChurchGroup::inRandomOrder()->first();
            $member->churchGroups()->attach($group->id);
        }
    }
}
