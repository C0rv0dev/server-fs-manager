<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\Folder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Testing\Fakes\Fake;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // for each folder, create a file
        $folders = Folder::all();

        // 40% of files per folder
        foreach ($folders as $folder) {
            $files = File::factory(3)->create([
                "path" => $folder->path . "/" . $folder->name,
                "user_id" => $folder->user->id,
                "folder_id" => $folder->id,
            ]);

            foreach ($files as $file) {
                // create user folder
                Storage::makeDirectory("{$folder->path}/{$folder->name}");

                // create file
                Storage::put(
                    "{$file->path}/{$file->name}.{$file->extension}",
                    "TEXT {$file->id}",
                );
            }
        }
    }
}
