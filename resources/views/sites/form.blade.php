@extends('layouts.admin.form')

@section('icon', 'building-o')
@section('title')
    {{ $site->id ? 'Edit' : 'Create' }} Site
@stop

@section('form')
<form data-parsley-validate action="/sites/{{ ($site->id) ? 'update/' . $site->id : 'store' }}" method="post" class="form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
        <label class="control-label col-sm-2">Name</label>
        <div class="col-sm-4">
            <input required type="text" name="name" placeholder="Name" class="form-control" value="{{ Input::old('name', $site->name) }}">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">Display Name</label>
        <div class="col-sm-4">
            <input required type="text" name="display_name" placeholder="Name" class="form-control" value="{{ Input::old('display_name', $site->display_name) }}">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">Company</label>
        <div class="col-sm-5">
            <select required class="form-control" name="company_id">
                <option value="">- Choose -</option>
                @foreach (\App\Models\Company::all() as $company)
                    <option{{ ($company->id == Input::old('company_id', $site->company_id)) ? ' selected' : '' }} value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-8">
            <button type="submit" class="btn btn-flat primary">Save Changes</button>
            <a href="/sites">Cancel</a>
        </div>
    </div>
</form>
@stop
