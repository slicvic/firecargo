<form action="/carrier/{{ $action }}" method="post" class="form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
        <label class="control-label col-sm-2">Name</label>
        <div class="col-sm-4">
            <input required type="text" name="name" placeholder="e.g. UPS" class="form-control" value="{{ Input::old('name', $carrier->name) }}">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-4 col-sm-offset-2">
            <a class="btn btn-white" href="/carriers">Cancel</a>
            <button class="btn btn-primary" type="submit">Save Carrier</button>
        </div>
    </div>
</form>
