<form action="/company/{{ $action }}" method="post" class="form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
        <label class="control-label col-sm-2">Name</label>
        <div class="col-sm-4">
            <input required type="text" name="name" placeholder="e.g. Coca Cola" class="form-control" value="{{ Input::old('name', $company->name) }}">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">Short Name</label>
        <div class="col-sm-4">
            <input required type="text" name="shortname" placeholder="e.g. CC" class="form-control" value="{{ Input::old('shortname', $company->shortname) }}">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-4 col-sm-offset-2">
            <a class="btn btn-white" href="/companies">Cancel</a>
            <button class="btn btn-primary" type="submit">Save Company</button>
        </div>
    </div>
</form>
