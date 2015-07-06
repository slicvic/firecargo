@extends('layouts.admin.model.form')

@section('icon', 'truck')

@section('title')
    {{ $type->id ? 'Edit' : 'Create' }} Package Type
@stop

@section('subtitle')
    {{ $type->id ? 'Update existing' : 'Create a New' }} Package Type
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
            <div class="col-sm-4 col-sm-offset-2">
                <a class="btn btn-white" href="/package-types">Cancel</a>
                <button class="btn btn-primary" type="submit">Save changes</button>
            </div>
        </div>
    </form>
@stop
