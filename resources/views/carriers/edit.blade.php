@extends('layouts.admin.page')

@section('icon', 'truck')

@section('title')
    {{ $carrier->exists ? 'Edit' : 'Create' }} Carrier
@stop

@section('subtitle')
<ol class="breadcrumb">
    <li>
        <a href="/carriers">Carriers</a>
    </li>
    <li class="active">
        <strong>{{ $carrier->exists ? 'Edit' : 'Create' }}</strong>
    </li>
</ol>
@stop

@section('page_content')
<form action="/carriers/{{ $carrier->exists ? 'update/' . $carrier->id : 'store' }}" method="post" class="form-horizontal">
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
            <button class="btn btn-primary" type="submit">Save changes</button>
        </div>
    </div>
</form>
@stop
