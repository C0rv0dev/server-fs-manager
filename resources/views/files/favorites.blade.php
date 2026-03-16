@extends('layouts.app')

@section('content')
    {{-- search bar --}}
    <div class="mb-3">
        <form action="{{ route('archives.starred') }}" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search favorites..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>

    <div class="mb-3">
        <ul class="list-group">
            @foreach ($favoriteArchives as $archive)
                {{-- check if archive is a file or folder --}}
                @if ($archive->isFile())
                    @include('components.file-item', ['file' => $archive->starrable])
                @else
                    @include('components.folders.folder-item', ['folder' => $archive->starrable])
                @endif
            @endforeach
        </ul>
    </div>

    {{ $favoriteArchives->links() }}
@endsection
