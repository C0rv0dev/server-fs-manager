{{-- resources/views/files/create.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column align-items-center w-100">
        <div class="card w-100 mb-4">
            <div class="card-body">
                <x-text.title
                    :title="'Upload Files'"
                    :align="'start'"
                />

                <form
                   id="fileUploadForm"
                   method="POST"
                   enctype="multipart/form-data"
                   action="{{ route('files.store') }}"
                   novalidate
                >
                    @csrf

                    {{-- hidden master input for files --}}
                    <input type="hidden" id="uploadedFiles" name="files[]" multiple />

                    <div class="mb-3">
                        <label class="form-label">Choose files (multiple)</label>
                        <input id="files" name="files[]" class="form-control" type="file" multiple>
                        <div class="form-text">Select one or more files from your device.</div>
                    </div>
                </form>

                <div class="d-flex w-100 align-items-center justify-content-center mt-5">
                    <button form="fileUploadForm" type="submit" class="btn btn-primary w-50">
                        Upload
                    </button>
                </div>
            </div>
        </div>

        <div class="card w-100">
            <div class="card-body">
                <x-text.title
                    :title="'Upload Folders'"
                    :align="'start'"
                />

                <form
                    id="folderUploadForm"
                    action="{{ route('folders.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    novalidate
                >
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Choose a folder (directory)</label>
                        <input id="directory" name="folder[]" class="form-control" type="file" webkitdirectory directory>
                        <div class="form-text">Select a folder to upload its contents.</div>
                    </div>

                    {{-- <hr> --}}

                    {{-- Folder Preview --}}
                    {{-- <x-text.title
                        :title="'Folder tree preview'"
                        :caption="'This preview is built from the selected files\' relative paths. Use the caret to expand/collapse folders.'"
                        :align="'start'"
                    />

                    <div id="treePreview" class="border rounded p-3" style="min-height:120px; max-height:400px; overflow:auto;">
                        <div class="text-muted">No files selected.</div>
                    </div> --}}

                    <div class="d-flex w-100 align-items-center justify-content-center mt-5">
                        <button form="folderUploadForm" type="submit" class="btn btn-primary w-50">
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- <style>
        #treePreview ul { list-style: none; padding-left: 1rem; margin: .25rem 0; }
        .tree-item { display:flex; align-items:center; gap:.5rem; cursor:default; }
        .folder { font-weight:600; cursor:pointer; user-select:none; }
        .file { color:#333; }
        .caret { width:1rem; display:inline-block; text-align:center; transform:rotate(0); transition:transform .12s ease; }
        .caret.open { transform:rotate(90deg); }
        .muted { color: #6c757d; font-size:.9rem; }
    </style> --}}
@endsection
