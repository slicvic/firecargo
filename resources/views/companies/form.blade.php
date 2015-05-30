@extends('layouts.members.form')

@section('icon', 'building-o')
@section('title')
    {{ $company->id ? 'Edit' : 'Create' }} Company
@stop

@section('form')
<form data-parsley-validate action="/companies/{{ ($company->id) ? 'update/' . $company->id : 'store' }}" method="post" class="form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
        <label class="control-label col-sm-2">Name</label>
        <div class="col-sm-4">
            <input required type="text" name="name" placeholder="Name" class="form-control" value="{{ Input::old('name', $company->name) }}">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-8">
            <button type="submit" class="btn btn-flat primary">Save Changes</button>
            <a href="/companies">Cancel</a>
        </div>
    </div>
</form>
@stop
