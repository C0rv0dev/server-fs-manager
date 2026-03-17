{{-- resources/views/components/search-bar.blade.php --}}
@props([
    'route',
    'placeholder',
    'params' => [],
    'method' => 'GET',
    'search' => request('search'),
])

<div class="mb-3">
    <form action="{{ route($route, $params) }}" method="{{ $method }}">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="{{ $placeholder }}" value="{{ $search }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
</div>
