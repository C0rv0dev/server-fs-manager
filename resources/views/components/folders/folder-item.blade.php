{{-- resources/views/components/folder-item.blade.php --}}
@props(['folder'])

<li class="list-group-item d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-2">
        <span class="me-2">
            <i class="fa-solid fa-folder"></i>
        </span>

        <div class="file-main">
            <div class="file-name fw-semibold">
                {{ $folder->name }}
            </div>

            @if(!empty($folder->tags))
                {{-- tag capsules --}}
                @foreach ($folder->tags as $tag)
                    <span class="badge badge-pill badge-secondary" style="background-color: gray;">
                        {{ $tag->name }}
                    </span>
                @endforeach
            @endif
        </div>
    </div>

    <div class="file-actions">
        <a href="{{ route('folders.show', $folder->hash) }}" class="btn btn-sm btn-outline-primary me-1" title="Open">
            Open
        </a>

        <button type="button" class="btn btn-sm btn-outline-secondary" title="More">
            ⋯
        </button>
    </div>
</li>
