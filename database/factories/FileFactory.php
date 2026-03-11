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
        $ext = ["txt", "pdf"];

        $file = [
            "name" => rand(1, 9999),
            "ext" => $this->faker->randomElement($ext),
            "content" => $this->faker->text(),
        ];

        // create the user associated with the file
        $user = User::factory()->create();

        // store file in storage, based on user id
        // remove space from name and set to lowercase
        $joinedUserName = join("_", [
            $user->id,
            strtolower(str_replace(" ", "_", $user->name)),
        ]);

        $path = "files/user/{$joinedUserName}/{$file["name"]}.{$file["ext"]}";

        Storage::put($path, $file["content"]);

        return [
            "name" => $file["name"],
            "path" => $path,
            "size" => Storage::size($path),
            "mime" => Storage::mimeType($path),
            "extension" => $file["ext"],
            "user_id" => $user->id,
        ];
    }
}
