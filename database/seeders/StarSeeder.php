<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\Folder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $files = File::all();
        $folders = Folder::all();

        foreach ($files as $file) {
            if (random_int(0, 1) === 0) {
                continue;
            }

            $file->favorites()->create([
                "user_id" => $file->user->id,
            ]);
        }

        foreach ($folders as $folder) {
            if (random_int(0, 1) === 0) {
                continue;
            }

            $folder->favorites()->create([
                "user_id" => $folder->user->id,
            ]);
        }
    }
}
