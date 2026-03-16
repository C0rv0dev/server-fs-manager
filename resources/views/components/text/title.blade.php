{{-- resources/views/components/text/title.blade.php --}}
@props([
'title',
'align' => 'center'|'start'|'end',
'caption' => null,
])

<div class="d-flex align-items-{{ $align }} flex-column mb-3">
    <h4 class="mb-0">
        {{ $title }}
    </h4>

    @if($caption)
        <span class="text-muted">{{ $caption }}</span>
    @endif
</div>
