<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(3);
        return [
            'slug' => Str::slug($title),
            'title' => $title,
            'cover' => $this->faker->randomElement([
                '0f2b4a46dee155e8716a135f589c0309.png',
                '1a35cfad3775955329ad84fe5ca2b758.png',
                '01HV4DP15NG64F2E3EE8KA65TJ.jpg',
                '3b1196466a3b23ae3d9b782e97ea1af1.png',
                '3d2b4c026bfe1e1c27c543c5560426a6.png',
                '4c1d0521291318a5e406b8c00d114cbf.png'
            ]),
            'content' => nl2br($this->faker->paragraph(3)),
            'published_at' => $this->faker->dateTimeBetween('-1 years'),
            'is_active' => $this->faker->boolean(80),
            'created_by' => User::first()->id
        ];
    }
}
