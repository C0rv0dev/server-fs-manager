{{-- resources/views/files/favorites.blade.php --}}
@extends('layouts.app')

@section('content')
    {{-- search bar --}}
    <x-search-bar :route="'archives.starred'" :placeholder="'Search favorites...'" />

    <div class="mb-3">
        <ul class="list-group">
            @foreach ($favoriteArchives as $archive)
                {{-- check if archive is a file or folder --}}
                @if ($archive->isFile())
                    <x-files.file-item :file="$archive->starrable" />
                @else
                    <x-folders.folder-item :folder="$archive->starrable" />
                @endif
            @endforeach
        </ul>
    </div>

    {{ $favoriteArchives->links() }}
@endsection
