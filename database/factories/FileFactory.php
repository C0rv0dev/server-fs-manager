<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ext = ["pdf", "txt"];

        return [
            "name" => $this->faker->word(),
            "size" => $this->faker->randomNumber(),
            "mime" => $this->faker->mimeType(),
            "extension" => $ext[rand(0, count($ext) - 1)],
        ];
    }
}
