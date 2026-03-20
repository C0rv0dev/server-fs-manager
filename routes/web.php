<?php

use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get("/", function () {
    return redirect()->route("home");
});

Route::group(["middleware" => Authenticate::class], function () {
    // Home
    Route::get("/home", [
        App\Http\Controllers\HomeController::class,
        "index",
    ])->name("home");

    // Folders
    Route::prefix("folders")->group(function () {
        Route::get("/{hash}", [
            App\Http\Controllers\FolderController::class,
            "show",
        ])->name("folders.show");
    });

    // Archives
    Route::prefix("archives")->group(function () {
        Route::get("/index", [
            App\Http\Controllers\ArchivesController::class,
            "index",
        ])->name("archives.index");

        Route::get("/create", [
            App\Http\Controllers\ArchivesController::class,
            "create",
        ])->name("archives.create");

        Route::get("/favorites", [
            App\Http\Controllers\ArchivesController::class,
            "favorites",
        ])->name("archives.starred");

        Route::get("/trashed", [
            App\Http\Controllers\ArchivesController::class,
            "trashed",
        ])->name("archives.trashed");

        Route::post("/store", [
            App\Http\Controllers\ArchivesController::class,
            "store",
        ])->name("archives.store");
    });
});
