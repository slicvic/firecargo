@extends('layouts.admin.page')

@section('icon', 'truck')

@section('title')
    {{ $type->exists ? 'Edit' : 'Add' }} Package Type
@stop

@section('subtitle')
<ol class="breadcrumb">
    <li>
        <a href="/package-types">Package Types</a>
    </li>
    <li class="active">
        <strong>{{ $type->exists ? 'Edit' : 'Create' }}</strong>
    </li>
</ol>
@stop

@section('page_content')
<form action="/package-type/{{ ($type->exists) ? $type->id . '/update' : 'store' }}" method="post" class="form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
        <label class="control-label col-sm-2">Name</label>
        <div class="col-sm-4">
            <input required type="text" name="name" placeholder="e.g. Box" class="form-control" value="{{ Input::old('name', $type->name) }}">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-4 col-sm-offset-2">
            <a class="btn btn-white" href="/package-types">Cancel</a>
            <button class="btn btn-primary" type="submit">Save</button>
        </div>
    </div>
</form>
@stop

