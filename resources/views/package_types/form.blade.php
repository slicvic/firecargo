@extends('layouts.members.form')

@section('icon', 'truck')
@section('title')
    {{ $type->id ? 'Edit' : 'Create' }} Package Type
@stop

@section('form')
<form data-parsley-validate action="/package-types/{{ ($type->id) ? 'update/' . $type->id : 'store' }}" method="post" class="form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="site_id" value="{{ ($type->id) ? $type->site_id : Auth::user()->site_id }}">
    <div class="form-group">
        <label class="control-label col-sm-2">Name</label>
        <div class="col-sm-4">
            <input required type="text" name="name" placeholder="e.g. Box" class="form-control" value="{{ Input::old('name', $type->name) }}">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-8">
            <button type="submit" class="btn btn-flat primary">Save Changes</button>
            <a href="/package-types">Cancel</a>
        </div>
    </div>
</form>
@stop

