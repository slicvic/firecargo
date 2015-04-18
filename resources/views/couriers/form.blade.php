@extends('layouts.members.form')

@section('icon', 'truck')
@section('title')
    {{ $courier->id ? 'Edit' : 'Create' }} Courier
@stop

@section('form')
<form data-parsley-validate action="/couriers/{{ ($courier->id) ? 'update/' . $courier->id : 'store' }}" method="post" class="form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="site_id" value="{{ ($courier->id) ? $courier->site_id : Auth::user()->site_id }}">
    <div class="form-group">
        <label class="control-label col-sm-2">Name</label>
        <div class="col-sm-4">
            <input required type="text" name="name" placeholder="e.g. UPS" class="form-control" value="{{ Input::old('name', $courier->name) }}">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-8">
            <button type="submit" class="btn btn-flat primary">Save Changes</button>
            <a href="/couriers">Cancel</a>
        </div>
    </div>
</form>
@stop
