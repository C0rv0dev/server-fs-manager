{{-- resources/views/components/folders/folder-badge.blade.php --}}
@props(['folder'])

<div class="mb-2">
    <a class="btn btn-sm btn-outline-secondary w-100" href="{{ route('folders.show', $folder->hash) }}">
        <span class="fw-bold">
            <span class="d-flex justify-content-between align-items-start flex-column">
                <div class="d-flex justify-content-between align-items-center w-100">
                    {{ $folder->name }}
                    <i class="fa-solid fa-folder"></i>
                </div>

                @if(!empty($folder->tags))
                    <div class="mt-1">
                        @foreach($folder->tags as $tag)
                            <span class="badge badge-pill bg-secondary">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                @endif
            </span>
        </span>
    </a>
</div>
