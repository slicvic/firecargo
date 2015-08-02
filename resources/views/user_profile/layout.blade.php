@extends('layouts.admin.page')

@section('title', 'My Profile')
@section('subtitle', 'Your Profile & Preferences')

@section('page_content')
<div class="row">
    <div class="col-md-4">
        <div class="ibox">
            <div class="ibox-content text-center">
                <h1>{{ Auth::user()->present()->fullname() }}</h1>
                <div id="photo-container" class="m-b-sm">
                    <img class="img-circle" src="{{ Auth::user()->present()->profilePhotoUrl('md') }}" style="width:200px;height:200px">
                </div>
                <button style="margin-top:4px;" type="button" id="edit-photo-btn" class="btn btn-block btn-link"><i class="fa fa-pencil"></i> Edit Photo</button>
                <div class="list-group">
                    <a href="/user/profile" class="{{ Request::is('user/profile') ? 'active ' : '' }}list-group-item btn btn-block btn-success">My Profile</a>
                    <a href="/user/edit" class="{{ Request::is('user/edit') ? 'active ' : '' }}list-group-item btn btn-block btn-success">Edit Profile</a>
                    <a href="/user/password" class="{{ Request::is('user/password') ? 'active ' : '' }}list-group-item btn btn-block btn-success">Change Password</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        @yield('user_profile_content')
    </div>
</div>

<script src="/assets/plugins/dropzone/dropzone.min.js"></script>
<script src="/assets/admin/js/user-profile.js"></script>
@stop
