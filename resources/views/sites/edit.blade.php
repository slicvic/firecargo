@extends('layouts.admin.page')

@section('icon', 'building-o')

@section('title')
    {{ $site->exists ? 'Edit' : 'Add New' }} Site
@stop

@section('subtitle')
<ol class="breadcrumb">
    <li>
        <a href="/sites">Sites</a>
    </li>
    <li class="active">
        <strong>{{ $site->exists ? 'Edit' : 'Add' }}</strong>
    </li>
</ol>
@stop

@section('page_content')
<form action="/sites/{{ ($site->exists) ? 'update/' . $site->id : 'store' }}" method="post" class="form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
        <label class="control-label col-sm-2">Company</label>
        <div class="col-sm-4">
            @include('companies._select', ['name' => 'company_id', 'selectedOption' => Input::old('company_id', $site->company_id)])
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">Name</label>
        <div class="col-sm-4">
            <input required type="text" name="name" placeholder="e.g. Google" class="form-control" value="{{ Input::old('name', $site->name) }}">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-4 col-sm-offset-2">
            <a class="btn btn-white" href="/sites">Cancel</a>
            <button class="btn btn-primary" type="submit">Save Site</button>
        </div>
    </div>
</form>
@stop
