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
        $users = User::all();

        foreach ($users as $user) {
            $userRootFolder =
                $user->id .
                "_" .
                strtolower(str_replace(" ", "_", $user->name));

            $folders = Folder::factory(3)->create([
                "user_id" => $user->id,
                "path" => "/files/users/{$userRootFolder}",
            ]);

            // for each folder, create a subfolder
            foreach ($folders as $folder) {
                Folder::factory(2)->create([
                    "user_id" => $user->id,
                    "parent_id" => $folder->id,
                    "path" => "{$folder->path}/{$folder->name}/",
                ]);
            }
        }
    }
}
