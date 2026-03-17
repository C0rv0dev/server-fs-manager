{{-- resources/views/components/file-item.blade.php --}}
@props(['file'])

<li class="list-group-item d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-2">
        <span class="me-2">
            <i class="fa-solid fa-file"></i>
        </span>

        <div class="file-main">
            <div class="file-name fw-semibold">
                {{ isset($file->name) ? e($file->named) : 'Unnamed' }}
            </div>

            @if(!empty($file->size))
                <div class="file-meta small text-muted">
                    {{ $file->formatted_size }}
                </div>
            @endif

            @if(!empty($file->tags))
                {{-- tag capsules --}}
                @foreach ($file->tags as $tag)
                    <span class="badge badge-pill bg-secondary">
                        {{ $tag->name }}
                    </span>
                @endforeach
            @endif
        </div>
    </div>

    <div class="file-actions">
        @if(!empty($file->path))
            <a href="{{ url($file->path) }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary me-1" title="Open">
                Open
            </a>
        @endif

        <button type="button" class="btn btn-sm btn-outline-secondary" title="More">
            ⋯
        </button>
    </div>
</li>
