<div class="title-action">
    <form class="form-inline" method="get" action="/packages">
        <div class="form-group">
            <label>Search: </label>
            <input type="text" class="form-control" name="search" value="{{ $params['search'] }}">
        </div>
        <div class="form-group">
            <label>Status: </label>
            <select class="form-control" name="status">
                <option value="">Any</option>
                @foreach ($statuses as $value => $name)
                    <option value="{{ $value }}"{{ $value === $params['status'] ? ' selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>
        @if ($params['search'] || $params['status'])
            <a href="/packages" class="btn btn-md btn-white" type="submit">Clear</a>
        @endif
        <button class="btn btn-md btn-primary" type="submit">Search</button>
    </form>
</div>
