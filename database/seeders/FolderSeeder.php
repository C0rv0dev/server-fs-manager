<?php

namespace Database\Seeders;

use App\Models\Folder;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class FolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // for each user, create a folder
        $users = User::all();

        foreach ($users as $user) {
            $folderName =
                $user->id .
                "_" .
                strtolower(str_replace(" ", "_", $user->name));

            Folder::factory(15)->create([
                "user_id" => $user->id,
                "path" => "/files/users/{$folderName}",
            ]);
        }
    }
}
