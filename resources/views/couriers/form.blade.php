@extends('layouts.admin.model.form')

@section('icon', 'truck')

@section('title')
    {{ $courier->id ? 'Edit' : 'Create' }} Courier
@stop

@section('subtitle')
    {{ $courier->id ? 'Update existing' : 'Create a New' }} Courier
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
            <div class="col-sm-4 col-sm-offset-2">
                <a class="btn btn-white" href="/couriers">Cancel</a>
                <button class="btn btn-primary" type="submit">Save changes</button>
            </div>
        </div>
    </form>
@stop
