{{-- resources/views/files/favorites.blade.php --}}
@extends('layouts.app')

@section('content')
    {{-- search bar --}}
    <x-search-bar :route="'archives.starred'" :placeholder="'Search favorites...'" />

    <div class="card mb-4">
        <div class="card-body">
            <x-text.title
                :title="'Favorites'"
                :align="'start'"
            />

            <div class="mb-3">
                @if($favoriteArchives->isNotEmpty())
                    <ul class="list-group mx-0">
                        @if ($archive->isFile())
                            <x-files.file-item :file="$archive->starrable" />
                        @else
                            <x-folders.folder-item :folder="$archive->starrable" />
                        @endif
                    </ul>
                @else
                    <p class="text-muted">No favorite files found.</p>
                @endif
            </div>
        </div>

    {{ $favoriteArchives->links() }}
@endsection
