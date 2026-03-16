<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // delete files/users folder from storage
        Storage::deleteDirectory("files");

        $this->call([
            UserSeeder::class,
            FolderSeeder::class,
            FileSeeder::class,
            TagSeeder::class,
            TagRelationSeeder::class,
            StarSeeder::class,
        ]);
    }
}
