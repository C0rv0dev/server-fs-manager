<?php

namespace App\Http\Controllers;

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
    public function show(string $hash) {}
}
