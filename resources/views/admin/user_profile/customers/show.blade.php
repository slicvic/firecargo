@extends('admin.user_profile.layout')

@section('user_profile_content')
<div class="ibox">
    <div class="ibox-content">
        <h2>Account Information</h2>
        <div class="row">
            <div class="col-xs-2"><strong>Name</strong></div>
            <div class="col-xs-10"><p>{{ $currentUser->account->name }}</p></div>
        </div>
        <div class="row">
            <div class="col-xs-2"><strong>Email</strong></div>
            <div class="col-xs-10"><p>{{ $currentUser->account->email }}</p></div>
        </div>
        <div class="row">
            <div class="col-xs-2"><strong>Phone</strong></div>
            <div class="col-xs-10"><p>{{ $currentUser->account->phone }}</p></div>
        </div>
        <div class="row">
            <div class="col-xs-2"><strong>Mobile</strong></div>
            <div class="col-xs-10"><p>{{ $currentUser->account->mobile_phone }}&nbsp;</p></div>
        </div>
        <div class="row">
            <div class="col-xs-2"><strong>Address</strong></div>
            <div class="col-xs-10"><p>{!! $currentUser->account->present()->address('shipping') !!}</p></div>
        </div>
    </div>
</div>

<div class="ibox">
    <div class="ibox-content">
        <h2>Preferences</h2>
        <div class="row">
            <div class="col-xs-3"><strong>Auto-ship Packages?</strong></div>
            <div class="col-xs-9">
                <p>{!! $currentUser->account->autoship ? '<span class="label label-primary">Yes</span>' : '<span class="label label-danger">No</span>' !!}</p>
                @include('admin.user_profile.customers._autoship_alert')
            </div>
        </div>
    </div>
</div>
@stop
