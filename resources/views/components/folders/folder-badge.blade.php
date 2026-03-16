{{-- resources/views/components/folders/folder-badge.blade.php --}}
@props(['folder'])

<div class="mb-2">
    <a class="btn btn-sm btn-outline-secondary w-100" href="{{ route('folders.show', $folder->hash) }}">
        <span class="fw-bold">
            <span class="d-flex justify-content-between align-items-center">
                {{ $folder->name }}
                <i class="fa-solid fa-folder"></i>
            </span>
        </span>
    </a>
</div>
