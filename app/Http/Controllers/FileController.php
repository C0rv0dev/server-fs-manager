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
    public function index()
    {
        return "view(files.index)";
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
