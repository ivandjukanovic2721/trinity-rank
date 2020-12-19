<?php

namespace Database\Factories;

use App\Models\Comments;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentsFactory extends Factory
{
    protected $model = Comments::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'content' => $this->faker->paragraph(5, true),
            'approved' => true
        ];
    }

    public function news()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'news',
            ];
        });
    }

    public function posts()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'posts',
            ];
        });
    }
}
