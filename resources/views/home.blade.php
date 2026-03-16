@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <h5 class="mb-3">Recent Folders</h5>
                        @if($folders->isNotEmpty())
                            <div class="row">
                                @foreach($folders as $folder)
                                    <div class="col-md-6">
                                        @include('components.folders.folder-badge', ['folder' => $folder])
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">No folders found.</p>
                        @endif
                    </div>

                    <div class="mb-4">
                        <h5 class="mb-3">Recent Files</h5>
                        @if($files->isNotEmpty())
                            <ul class="list-group">
                                @foreach($files as $file)
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
