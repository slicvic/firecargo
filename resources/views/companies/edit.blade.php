@extends('layouts.admin.page')

@section('icon', 'building-o')

@section('title')
    {{ $company->exists ? 'Edit' : 'Create' }} Company
@stop

@section('subtitle')
<ol class="breadcrumb">
    <li>
        <a href="/companies">Companies</a>
    </li>
    <li class="active">
        <strong>{{ $company->exists ? 'Edit' : 'Create' }}</strong>
    </li>
</ol>
@stop

@section('page_content')
<form action="/companies/{{ $company->exists ? 'update/' . $company->id : 'store' }}" method="post" class="form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
        <label class="control-label col-sm-2">Name</label>
        <div class="col-sm-4">
            <input required type="text" name="name" placeholder="Name" class="form-control" value="{{ Input::old('name', $company->name) }}">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">Corp Code</label>
        <div class="col-sm-4">
            <input required type="text" name="corp_code" placeholder="Corp Code" class="form-control" value="{{ Input::old('corp_code', $company->corp_code) }}">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-4 col-sm-offset-2">
            <a class="btn btn-white" href="/companies">Cancel</a>
            <button class="btn btn-primary" type="submit">Save changes</button>
        </div>
    </div>
</form>
@stop