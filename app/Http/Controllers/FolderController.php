<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FolderController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param string $hash
     * @return View
     */
    public function show(Request $request, string $hash): View
    {
        $search = $request->input("search");

        $folder = Folder::with([
            "children" => function ($q) use ($search) {
                if ($search) {
                    $q->where("name", "like", "%{$search}%");
                }
            },
            "files" => function ($q) use ($search) {
                if ($search) {
                    $q->where("name", "like", "%{$search}%");
                }
            },
            "tags",
            "parent",
        ])
            ->where("hash", $hash)
            ->firstOrFail();

        return view("folders.show.view", compact("folder"));
    }

    /**
     * Store folder and its contents.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        dd($request->all());
    }
}
