<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        // clear storage before seeding
        Storage::deleteDirectory("/files");

        foreach ($users as $user) {
            $folders = $user->folders;
            $userRootFolder =
                $user->id .
                "_" .
                strtolower(str_replace(" ", "_", $user->name));

            $userRootPath = "/files/users/" . $userRootFolder;

            // create 3 files in root folder
            $this->createFilesInFolder($userRootPath, $user->id);

            // create 3 files in each folder
            foreach ($folders as $folder) {
                $this->createFilesInFolder(
                    $folder->path . "/" . $folder->name,
                    $folder->user->id,
                    $folder->id,
                );
            }
        }
    }

    private function createFilesInFolder(
        string $path,
        int $user_id,
        ?int $parent_folder_id = null,
    ) {
        $files = File::factory(3)->create([
            "path" => $path,
            "user_id" => $user_id,
            "folder_id" => $parent_folder_id,
        ]);

        foreach ($files as $file) {
            // create user folder
            Storage::makeDirectory("{$path}");

            // create file
            Storage::put(
                "{$file->path}/{$file->name}.{$file->extension}",
                "TEXT {$file->id}",
            );
        }
    }
}
