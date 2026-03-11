<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Folder;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware("auth");
    }

    /**
     * Show the application dashboard.
     *
     * Build a stable folder/file tree to avoid index/undefined errors when
     * rendering nested folders in the view. This method ensures every folder
     * has a `children` collection and attaches files to their folder's
     * children collection (or collects them as root files).
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userId = Auth::user()->id;

        $rootFiles = collect();

        // Load all folders and files for the authenticated user
        $folders = Folder::where("user_id", $userId)->get();
        $files = File::where("user_id", $userId)->get();

        // Prepare a map of folders by id to avoid index/undefined errors when
        // recursing nested folders.
        $byId = $folders->keyBy("id");
        foreach ($folders as $folder) {
            // to be populated below
            $folder->children_folders = collect();
            $folder->children_files = collect();
            $folder->children = collect();
        }

        foreach ($folders as $folder) {
            if (!empty($folder->parent_id) && $byId->has($folder->parent_id)) {
                $byId[$folder->parent_id]->children_folders->push($folder);
            }
        }

        foreach ($files as $file) {
            if (!empty($file->folder_id) && $byId->has($file->folder_id)) {
                $byId[$file->folder_id]->children_files->push($file);
            } else {
                $rootFiles->push($file);
            }
        }

        foreach ($folders as $folder) {
            $folder->children = $folder->children_folders->merge(
                $folder->children_files,
            );
        }

        $rootFolders = $folders->filter(fn() => empty($f->parent_id))->values();

        return view("home", [
            "folders" => $folders,
            "files" => $files,
            "rootFolders" => $rootFolders,
            "rootFiles" => $rootFiles,
        ]);
    }
}
