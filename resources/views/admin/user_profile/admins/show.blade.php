@extends('admin.user_profile.layout')

@section('user_profile_content')
<div class="ibox">
    <div class="ibox-content">
        <h2>Account Info</h2>
        <div class="row">
            <div class="col-xs-2"><strong>Name</strong></div>
            <div class="col-xs-10"><p>{{ $currentUser->present()->fullname() }}</p></div>
        </div>
        <div class="row">
            <div class="col-xs-2"><strong>Email</strong></div>
            <div class="col-xs-10"><p>{{ $currentUser->email }}</p></div>
        </div>
    </div>
</div>
@stop
