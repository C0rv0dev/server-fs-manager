<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $search = $request->input("search");

        $files = $user
            ->files()
            ->when($search, function ($query) use ($search) {
                $query->where("name", "like", "%{$search}%");
            })
            ->orderBy("created_at", "desc")
            ->paginate(15, ["*"], "files_page");

        $folders = $user
            ->folders()
            ->when($search, function ($query) use ($search) {
                $query->where("name", "like", "%{$search}%");
            })
            ->orderBy("created_at", "desc")
            ->paginate(10, ["*"], "folders_page");

        return view("files.list", compact("files", "folders"));
    }

    /**
     * Display a listing of favorites.
     *
     * @return View|RedirectResponse
     */
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

        return view("files.favorites", compact("favoriteArchives"));
    }
}
