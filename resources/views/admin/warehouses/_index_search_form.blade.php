<div class="title-action">
    <form class="form-inline" method="get" action="/warehouses">
        <div class="form-group">
            <label>Search: </label>
            <input type="text" class="form-control" name="search" minlength="3" value="{{ $params['search'] }}">
        </div>
        @if ($params['search'])
            <a href="/warehouses" class="btn btn-md btn-white" type="submit">Clear</a>
        @endif
        <button class="btn btn-md btn-primary" type="submit">Search</button>
    </form>
</div>
