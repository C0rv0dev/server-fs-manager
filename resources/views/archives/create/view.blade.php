{{-- resources/views/files/create.blade.php --}}
@extends('layouts.app')

{{-- import scripts --}}
@vite('resources/js/archives/create/scripts.js')

{{-- define styles --}}
<style>
    #treePreview ul { padding-left: 1rem; margin: .25rem 0; }
    .tree-item { display:flex; align-items:center; gap:.5rem; cursor:default; }
    .folder { font-weight:600; cursor:pointer; user-select:none; }
    .file { color:#333; }
    .caret { width:1rem; display:inline-block; text-align:center; transform:rotate(0); transition:transform .12s ease; }
    .caret.open { transform:rotate(90deg); }
    .muted { color: #6c757d; font-size:.9rem; }
</style>

{{-- content --}}
@section('content')
    <form
        id="uploadForm"
        method="POST"
        enctype="multipart/form-data"
        action="{{ route('archives.store') }}"
        novalidate
    >
        @csrf

        <div class="d-flex flex-column align-items-center w-100">
            <div class="card w-100 mb-4">
                <div class="card-body">
                    <x-text.title
                        :title="'Upload Files'"
                        :align="'start'"
                    />

                    <label class="form-label">Choose files (multiple)</label>
                    <input id="filesInput" name="files[]" class="form-control" type="file" multiple>
                    <div class="form-text">Select one or more files from your device.</div>
                </div>
            </div>

            <div class="card w-100 mb-4">
                <div class="card-body">
                    <x-text.title
                        :title="'Upload Folders'"
                        :align="'start'"
                    />

                    <label class="form-label">Choose a folder (directory)</label>
                    <input id="foldersInput" name="folders[]" class="form-control" type="file" webkitdirectory directory>
                    <div class="form-text">Select a folder to upload its contents.</div>
                </div>
            </div>

            <div class="card w-100">
                <div class="card-body">
                    {{-- Folder Preview --}}
                    <x-text.title
                        :title="'Folder tree preview'"
                        :caption="'This preview is built from the selected files\' relative paths. Use the caret to expand/collapse folders.'"
                        :align="'start'"
                    />

                    {{-- Total Size --}}
                    <div class="text-muted mb-2">Total size: <span id="totalSize">0 Bytes</span></div>

                    <x-archives.tree-preview />

                    <div class="d-flex w-100 align-items-center justify-content-center mt-4 mb-2">
                        <button form="uploadForm" type="submit" class="btn btn-primary w-50">
                            Upload
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
