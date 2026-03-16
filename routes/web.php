<?php

use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get("/", function () {
    return redirect()->route("home");
});

Route::group(["middleware" => Authenticate::class], function () {
    Route::get("/home", [
        App\Http\Controllers\HomeController::class,
        "index",
    ])->name("home");

    Route::prefix("folders")->group(function () {
        Route::get("/{hash}", [
            App\Http\Controllers\FolderController::class,
            "show",
        ])->name("folders.show");
    });

    Route::prefix("files")->group(function () {
        Route::get("/index", [
            App\Http\Controllers\FileController::class,
            "index",
        ])->name("files.index");
    });

    Route::get("/favorites", [
        App\Http\Controllers\FileController::class,
        "favorites",
    ])->name("archives.starred");
});
