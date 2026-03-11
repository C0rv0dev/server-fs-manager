@extends('layouts.app')

@php
    $rootFolders = $folders->filter(fn($f) => empty($f->parent_id));
    $rootFiles = $files->filter(fn($f) => empty($f->folder_id));
@endphp

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <h5 class="mb-3">Folders</h5>
                        @if($rootFolders->isNotEmpty())
                            @foreach($rootFolders as $folder)
                                @include('components.folders.folder-accordion', ['folder' => $folder])
                            @endforeach
                        @else
                            <p class="text-muted">No folders found.</p>
                        @endif
                    </div>

                    <div class="mb-4">
                        <h5 class="mb-3">Files (root)</h5>
                        @if($rootFiles->isNotEmpty())
                            <ul class="list-group">
                                @foreach($rootFiles as $file)
                                    @include('components.file-item', ['file' => $file])
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">No root files found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
