{{-- resources/views/components/folders/folder-accordion.blade.php --}}
@props(['folder', 'parentAccordionId' => null])

@php
    $baseId = 'folder_' . ($parentAccordionId == null ? "root_" : null) . ($folder->id ?? uniqid());
    $accordionId = $baseId . '_acc';
    $headingId = $baseId . '_heading';
    $collapseId = $baseId . '_collapse';
    $dataParent = $parentAccordionId ? ' data-bs-parent="#' . e($parentAccordionId) . '"' : '';

    $childFolders = $folder->children_folders ?? ($folder->relationLoaded('children') ? $folder->children : ($folder->children()->get() ?? collect()));
    $childFiles   = $folder->children_files ?? ($folder->files_collection ?? ($folder->relationLoaded('files') ? $folder->files : ($folder->files()->get() ?? collect())));
@endphp

<div class="accordion mb-2" id="{{ $accordionId }}">
    <div class="accordion-item">
        <h2 class="accordion-header" id="{{ $headingId }}">
            <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#{{ $collapseId }}"
                aria-expanded="false"
                aria-controls="{{ $collapseId }}"
            >
                <span class="fw-bold">
                    {{ e($folder->name) }}
                </span>
            </button>
        </h2>

        <div id="{{ $collapseId }}" class="accordion-collapse collapse" aria-labelledby="{{ $headingId }}">
            <div class="accordion-body p-0">
                <ul class="list-group list-group-flush">
                    @if($childFolders->isNotEmpty() || $childFiles->isNotEmpty())
                        @foreach($childFolders as $childFolder)
                            <li class="list-group-item p-0">
                                @include('components.folders.folder-accordion', ['folder' => $childFolder, 'parentAccordionId' => $accordionId])
                            </li>
                        @endforeach

                        @foreach($childFiles as $file)
                            @include('components.file-item', ['file' => $file])
                        @endforeach
                    @else
                        <li class="list-group-item text-muted">(empty)</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
