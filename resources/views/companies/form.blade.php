@extends('layouts.admin.model.form')

@section('icon', 'building-o')

@section('title')
    {{ $company->id ? 'Edit' : 'Create' }} Company
@stop

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="/companies">Companies</a>
        </li>
        <li class="active">
            <strong>{{ $company->id ? 'Edit' : 'Create' }}</strong>
        </li>
    </ol>
@stop

@section('form')
    <div class="iboxx">
        <div class="iboxx-content">
            <form data-parsley-validate action="/companies/{{ ($company->id) ? 'update/' . $company->id : 'store' }}" method="post" class="form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label class="control-label col-sm-2">Name</label>
                    <div class="col-sm-4">
                        <input required type="text" name="name" placeholder="Name" class="form-control" value="{{ Input::old('name', $company->name) }}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <a class="btn btn-white" href="/companies">Cancel</a>
                        <button class="btn btn-primary" type="submit">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
