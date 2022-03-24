<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Task::class;
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'content' => $this->faker->text
        ];
    }
}
