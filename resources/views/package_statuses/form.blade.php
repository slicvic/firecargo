@extends('layouts.admin.form')

@section('icon', 'info-circle')
@section('title')
    {{ $status->id ? 'Edit' : 'Create' }} Package Status
@stop

@section('form')
<form data-parsley-validate action="/package-statuses/{{ ($status->id) ? 'update/' . $status->id : 'store' }}" method="post" class="form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="site_id" value="{{ ($status->id) ? $status->site_id : Auth::user()->site_id }}">
    <div class="form-group">
        <label class="control-label col-sm-2">Name</label>
        <div class="col-sm-4">
            <input required type="text" name="name" placeholder="e.g. Processing" class="form-control" value="{{ Input::old('name', $status->name) }}">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">Color</label>
        <div class="col-sm-4">
            <input type="color" name="color" class="form-control" value="{{ Input::old('color', $status->color) }}">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">Default?</label>
        <div class="col-sm-4">
            <input type="checkbox" name="is_default" class="form-control" value="1"<?php echo Input::old('is_default', $status->is_default) ? ' checked' : ''; ?>>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-8">
            <button type="submit" class="btn btn-flat primary">Save Changes</button>
            <a href="/package-statuses">Cancel</a>
        </div>
    </div>
</form>
@stop
