<form action="/package-type/{{ $action }}" method="post" class="form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
        <label class="control-label col-sm-2">Name</label>
        <div class="col-sm-4">
            <input required type="text" name="name" placeholder="e.g. Box" class="form-control" value="{{ old('name', $type->name) }}">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-4 col-sm-offset-2">
            <a class="btn btn-white" href="/package-types">Cancel</a>
            <button class="btn btn-primary" type="submit">Save</button>
        </div>
    </div>
</form>
