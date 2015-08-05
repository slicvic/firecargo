<div class="title-action">
    <form class="form-inline" method="get" action="/warehouses">
        <div class="form-group">
            <label>Search: </label>
            <input type="text" class="form-control" name="search" minlength="3" value="{{ $params['search'] }}">
        </div>
        <div class="form-group">
            <label>Status: </label>
            <select class="form-control" name="status_id">
                <option value="">Any</option>
                @foreach (\App\Models\WarehouseStatus::all() as $status)
                    <option value="{{ $status->id }}"{{ ($status->id == $params['status_id']) ? ' selected' : '' }}>{{ $status->name }}</option>
                @endforeach
            </select>
        </div>
        @if ($params['search'] || $params['status_id'])
            <a href="/warehouses" class="btn btn-md btn-white" type="submit">Clear</a>
        @endif
        <button class="btn btn-md btn-primary" type="submit">Search</button>
    </form>
</div>
