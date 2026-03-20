<?php

namespace App\Http\Controllers;

use App\Http\Services\ArchiveService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArchivesController extends Controller
{
    public function __construct(private readonly ArchiveService $archiveService)
    {
        //
    }

    /**
     * Show paginated files and folders (root-level).
     */
    public function index(Request $request): View
    {
        return $this->archiveService->index($request);
    }

    /**
     * Display favorite (starred) archives for the user.
     */
    public function favorites(Request $request): View|RedirectResponse
    {
        return $this->archiveService->favorites($request);
    }

    /**
     * Show trashed files and folders.
     */
    public function trashed(Request $request): View
    {
        return $this->archiveService->trashed($request);
    }

    /**
     * Show upload form.
     */
    public function create(): View
    {
        return $this->archiveService->create();
    }

    /**
     * Store a new archive or folder.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->archiveService->store($request);
    }
}
