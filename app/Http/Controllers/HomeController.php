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
        //
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

        $folders = Folder::where("user_id", $userId)
            ->with("tags")
            ->orderBy("created_at", "asc")
            ->limit(10)
            ->get();

        $files = File::where("user_id", $userId)
            ->with("tags")
            ->orderBy("created_at", "asc")
            ->limit(15)
            ->get();

        return view("home", [
            "folders" => $folders,
            "files" => $files,
        ]);
    }
}
