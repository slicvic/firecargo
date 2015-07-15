@extends('layouts.admin.page')

@section('title')
    {{ $role->exists ? 'Edit' : 'Create' }} Role
@stop

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="/roles">Roles</a>
        </li>
        <li class="active">
            <strong>{{ $role->exists ? 'Edit' : 'Create' }}</strong>
        </li>
    </ol>
@stop

@section('page_content')
<form action="/roles/{{ ($role->exists) ? 'update/' . $role->id : 'store' }}" method="post" class="form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
        <label class="control-label col-sm-2">Name</label>
        <div class="col-sm-3">
            <input required type="text" name="name" placeholder="Name" class="form-control" value="{{ Input::old('name', $role->name) }}">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">Description</label>
        <div class="col-sm-5">
            <input type="text" name="description" placeholder="Description" class="form-control" value="{{ Input::old('description', $role->description) }}">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-4 col-sm-offset-2">
            <a class="btn btn-white" href="/roles">Cancel</a>
            <button class="btn btn-primary" type="submit">Save changes</button>
        </div>
    </div>
</form>
@stop
