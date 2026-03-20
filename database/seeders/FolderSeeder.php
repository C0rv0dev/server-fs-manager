<?php

namespace Database\Seeders;

use App\Models\Folder;
use App\Models\User;
use Illuminate\Database\Seeder;

class FolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $folders = Folder::factory(3)->create([
                "user_id" => $user->id,
                "path" => $user->root_folder,
            ]);

            // for each folder, create a subfolder
            foreach ($folders as $folder) {
                Folder::factory(2)->create([
                    "user_id" => $user->id,
                    "parent_id" => $folder->id,
                    "path" => "{$folder->path}/{$folder->name}",
                ]);
            }
        }
    }
}
