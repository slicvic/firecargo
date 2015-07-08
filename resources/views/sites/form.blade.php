@extends('layouts.admin.model.form')

@section('icon', 'building-o')

@section('title')
    {{ $site->id ? 'Edit' : 'Create' }} Site
@stop

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="/sites">Sites</a>
        </li>
        <li class="active">
            <strong>{{ $site->id ? 'Edit' : 'Create' }}</strong>
        </li>
    </ol>
@stop

@section('form')

        <form data-parsley-validate action="/sites/{{ ($site->id) ? 'update/' . $site->id : 'store' }}" method="post" class="form-horizontal">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            @if (Auth::user()->isAdmin())
                <div class="form-group">
                    <label class="control-label col-sm-2">Master</label>
                    <div class="col-sm-5">
                        <select required class="form-control" name="company_id">
                            <option value="">- Choose -</option>
                            @foreach (\App\Models\Company::all() as $company)
                                <option{{ ($company->id == Input::old('company_id', $site->company_id)) ? ' selected' : '' }} value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif

            <div class="form-group">
                <label class="control-label col-sm-2">Name</label>
                <div class="col-sm-4">
                    <input required type="text" name="name" placeholder="Name" class="form-control" value="{{ Input::old('name', $site->name) }}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Display Name</label>
                <div class="col-sm-4">
                    <input required type="text" name="display_name" placeholder="Display Name" class="form-control" value="{{ Input::old('display_name', $site->display_name) }}">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-2">
                    <a class="btn btn-white" href="/sites">Cancel</a>
                    <button class="btn btn-primary" type="submit">Save changes</button>
                </div>
            </div>
        </form>
@stop
