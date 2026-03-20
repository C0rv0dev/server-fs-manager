{{-- resources/views/folders/show.blade.php --}}
@extends('layouts.app')

@section('content')
    {{-- search bar --}}
    <x-search-bar
        :route="'folders.show'"
        :params="['hash' => $folder->hash]"
        :placeholder="'Search files...'"
    />

    <div class="card mb-4">
        <div class="card-body">
            <x-text.title
                :title="'Folders'"
                :align="'start'"
            />

            <div class="mb-3">
                @if($folder->children->isNotEmpty())
                    <div class="row">
                        @foreach($folder->children as $child)
                            <div class="col-md-6">
                                <x-folders.folder-badge :folder="$child" />
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No folders found.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <x-text.title
                :title="'Files'"
                :align="'start'"
            />

            {{-- dropdown filters --}}
            <div class="d-flex gap-2 mb-3">
                <select class="form-select">
                    <option>Ascending</option>
                    <option>Descending</option>
                </select>

                <select class="form-select">
                    <option>PDF</option>
                    <option>Image</option>
                    <option>Document</option>
                    <option>Text</option>
                    <option>Other</option>
                </select>

                <select class="form-select">
                    <option>Work</option>
                    <option>Personal</option>
                    <option>Other</option>
                </select>
            </div>

            <div class="mb-3">
                @if($folder->files->isNotEmpty())
                    <ul class="list-group mx-0">
                        @foreach($folder->files as $file)
                            <x-files.file-item :file="$file" />
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No root files found.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
