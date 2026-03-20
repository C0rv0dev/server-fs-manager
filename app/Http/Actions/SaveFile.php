<?php

namespace App\Http\Actions;

use App\Models\File;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SaveFile
{
    public static function exec(Request $request): array
    {
        $user = Auth::user();

        $files = $request->file("files", []);
        $folders = $request->file("folders", []);

        $errors = [];

        foreach ($files as $file) {
            try {
                self::storeFile($user, $file, null);
            } catch (\Exception $e) {
                $errors[] = "{$file->getClientOriginalName()}: {$e->getMessage()}";
            }
        }

        foreach ($folders as $file) {
            try {
                new self()->storeFileWithPath($user, $file);
            } catch (\Exception $e) {
                $errors[] = "{$file->getClientOriginalPath()}: {$e->getMessage()}";
            }
        }

        return [
            "errors" => $errors,
            "success" => empty($errors),
        ];
    }

    private static function storeFile(
        User $user,
        UploadedFile $file,
        ?Folder $folder,
    ): void {
        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $basePath = $folder
            ? "{$folder->path}/{$folder->name}"
            : $user->root_folder;

        $fullPath = ltrim($basePath, "/");

        if (
            $user
                ->files()
                ->where("folder_id", $folder?->id)
                ->where("name", $fileName)
                ->exists()
        ) {
            throw new \Exception("File already exists.");
        }

        // ensure directory exists
        Storage::makeDirectory($basePath);

        // store file
        $file->storeAs(
            $basePath,
            "{$fileName}.{$file->getClientOriginalExtension()}",
        );

        File::create([
            "name" => $fileName,
            "path" => $fullPath,
            "folder_id" => $folder?->id,
            "user_id" => $user->id,
            "extension" => $file->getClientOriginalExtension(),
            "mime" => $file->getClientMimeType(),
            "size" => $file->getSize(),
        ]);
    }

    private static function storeFileWithPath(
        User $user,
        UploadedFile $file,
    ): void {
        // Get the path and split into parts
        $path = $file->getClientOriginalPath();
        $parts = explode("/", $path);
        $fileName = array_pop($parts);

        // Build folder structure recursively
        $folder = self::buildFolderTree($user, $parts);

        // Store file
        try {
            self::storeFile($user, $file, $folder);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private static function buildFolderTree(
        User $user,
        array $parts,
        ?Folder $parent = null,
    ): ?Folder {
        if (empty($parts)) {
            return $parent;
        }

        $currentName = array_shift($parts);

        $folder = self::verifyFolder($user, $currentName, $parent);

        return self::buildFolderTree($user, $parts, $folder);
    }

    private static function verifyFolder(
        User $user,
        string $name,
        ?Folder $parent,
    ): Folder {
        $folder = $user
            ->folders()
            ->where("name", $name)
            ->where("parent_id", $parent?->id)
            ->first();

        if ($folder) {
            return $folder;
        }

        $path = $parent
            ? "{$parent->path}/{$parent->name}"
            : rtrim($user->root_folder, "/");

        return Folder::create([
            "name" => $name,
            "user_id" => $user->id,
            "parent_id" => $parent?->id,
            "path" => $path,
        ]);
    }
}
