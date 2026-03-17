{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column">
        <div class="card mb-4">
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="mb-4">
                    <x-text.title
                        :title="'Recent Folders'"
                        :align="'start'"
                        :caption="'Last 10 folders added'"
                    />

                    @if($folders->isNotEmpty())
                        <div class="row">
                            @foreach($folders as $folder)
                                <div class="col-md-6">
                                    <x-folders.folder-badge :folder="$folder" />
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No folders found.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="mb-4">
                    <x-text.title
                        :title="'Recent Files'"
                        :align="'start'"
                        :caption="'Last 15 files added'"
                    />

                    @if($files->isNotEmpty())
                        <ul class="list-group">
                            @foreach($files as $file)
                                <x-files.file-item :file="$file" />
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No root files found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
