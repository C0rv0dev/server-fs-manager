<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Database\Factories\FolderFactory;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("folders.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $hash)
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

        return view("folders.show", compact("folder"));
    }
}
