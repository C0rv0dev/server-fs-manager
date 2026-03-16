<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\Folder;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagRelationSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $files = File::all();
        $folders = Folder::all();
        $tags = Tag::all();

        foreach ($files as $file) {
            $file->tags()->attach($tags->random(rand(1, 3))->pluck("id"));
        }

        foreach ($folders as $folder) {
            $folder->tags()->attach($tags->random(rand(1, 3))->pluck("id"));
        }
    }
}
