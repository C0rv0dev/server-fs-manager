{{-- resources/views/layouts/components/sidebar-item.blade.php --}}
@props([
    'route',
    'label',
    'small',
    'icon',
])

<a href="{{ route($route) }}" class="list-group-item list-group-item-action {{ request()->routeIs($route) ? 'active' : '' }}">
    <div class="d-flex align-items-center">
            <i class="fa-solid {{ $icon }} me-2"></i>

            <div class="d-inline-block">
                {{ $label }}

                <div class="small">
                    {{ $small }}
                </div>
        </div>
    </div>
</a>
