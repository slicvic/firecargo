@extends('layouts.admin.page')

@section('icon', 'user')

@section('title')
    {{ $user->exists ? 'Edit User # ' . $user->id : 'Add New User' }}
@stop

@section('subtitle')
<ol class="breadcrumb">
    <li>
        <a href="/users">Users</a>
    </li>
    <li class="active">
        <strong>{{ $user->exists ? 'Edit' : 'Create' }}</strong>
    </li>
</ol>
@stop

@section('page_content')
<form action="/users/{{ $user->exists ? 'update/' . $user->id : 'store' }}" method="post" class="form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <h3>Account Info</h3>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Company *</label>
                        <div class="col-sm-4">
                            @include('companies._select', ['name' => 'user[company_id]', 'selectedOption' => Input::old('user.company_id', $user->company_id)])
                        </div>
                    </div>
                    <div class="clear hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Role *</label>
                        <div class="col-sm-3">
                            <select required class="form-control" name="user[role_id]">
                            <option value="">- Choose -</option>
                            @foreach (\App\Models\Role::all() as $role)
                                <option value="{{ $role->id }}"{{ ($role->id == Input::old('user.role_id', $user->role_id)) ? ' selected' : '' }}>{{ $role->name }} ({{ $role->description }})</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="clear hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">First Name</label>
                        <div class="col-sm-4">
                            <input required type="text" name="user[firstname]" placeholder="First Name" class="form-control" value="{{ Input::old('user.firstname', $user->firstname) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Last Name</label>
                        <div class="col-sm-4">
                            <input required type="text" name="user[lastname]" placeholder="Last Name" class="form-control" value="{{ Input::old('user.lastname', $user->lastname) }}">
                        </div>
                    </div>
                    <div class="clear hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Email</label>
                        <div class="col-sm-5">
                            <input required type="email" name="user[email]" placeholder="Email" class="form-control" value="{{ Input::old('user.email', $user->email) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Password</label>
                        <div class="col-sm-5">
                            <input type="password" name="user[password]" placeholder="Password" class="form-control" minlength="8">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Active</label>
                        <div class="col-sm-5">
                            <input type="checkbox" class="icheck-green" value="1" name="user[active]"{{ Input::old('user.active', $user->active) ? ' checked' : '' }}>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <a class="btn btn-white" href="/users">Cancel</a>
                            <button class="btn btn-primary" type="submit">Save User</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@stop
