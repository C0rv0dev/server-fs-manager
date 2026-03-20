<?php

namespace App\Http\Services;

use App\Http\Actions\SaveFile;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ArchiveService
{
    public function index(Request $request): View
    {
        $user = Auth::user();

        $search = $request->input("search");

        $files = $user
            ->files()
            ->where("folder_id", null)
            ->when($search, function ($query) use ($search) {
                $query->where("name", "like", "%{$search}%");
            })
            ->orderBy("created_at", "desc")
            ->paginate(15, ["*"], "files_page");

        $folders = $user
            ->folders()
            ->where("parent_id", null)
            ->when($search, function ($query) use ($search) {
                $query->where("name", "like", "%{$search}%");
            })
            ->orderBy("created_at", "desc")
            ->paginate(10, ["*"], "folders_page");

        return view("archives.index.view", compact("files", "folders"));
    }

    public function favorites(Request $request): View|RedirectResponse
    {
        $user = Auth::user();

        if ($request->has("search")) {
            $search = $request->input("search");

            $favoriteArchives = $user
                ->starred()
                ->with("starrable")
                ->whereHas("starrable", function ($query) use ($search) {
                    $query->where("name", "like", "%{$search}%");
                })
                ->orderBy("created_at", "asc")
                ->paginate(15);
        } else {
            $favoriteArchives = $user
                ->starred()
                ->with("starrable")
                ->orderBy("created_at", "asc")
                ->paginate(15);
        }

        return view("archives.favorites.view", compact("favoriteArchives"));
    }

    /**
     * Show trashed files and folders.
     */
    public function trashed(Request $request): View
    {
        $user = Auth::user();

        $files = $user
            ->files()
            ->onlyTrashed()
            ->orderBy("deleted_at", "desc")
            ->paginate(15, ["*"], "trashed_files_page");

        $folders = $user
            ->folders()
            ->onlyTrashed()
            ->orderBy("deleted_at", "desc")
            ->paginate(15, ["*"], "trashed_folders_page");

        return view("archives.trashed.view", compact("files", "folders"));
    }

    public function create(): View
    {
        return view("archives.create.view");
    }

    /**
     * Store a new archive or folder.
     */
    public function store(Request $request): RedirectResponse
    {
        $result = SaveFile::exec($request);

        return redirect()
            ->route("archives.index")
            ->with("upload_result", $result);
    }
}
