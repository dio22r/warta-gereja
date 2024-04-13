<?php

namespace Database\Factories;

use App\Models\Family;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class MemberFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Member::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'gender' => $this->faker->randomElement(['F', 'M']),
            'birth_date' => $this->faker->date('Y-m-d'),
            'birth_place' => $this->faker->city,
            'blood_group' => $this->faker->bloodGroup,
            'address' => $this->faker->address,
            'telp' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'marital_status' => $this->faker->randomElement(['S', 'M', 'J', 'D']),
            'status' => Member::STATUS_ACTIVE,
            'family_id' => Family::inRandomOrder()->first()->id
        ];
    }
}
