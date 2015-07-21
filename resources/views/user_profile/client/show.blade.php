@extends('user_profile.layout')

@section('user_profile_content')
<div class="ibox">
    <div class="ibox-content">
        <h2>Personal Information</h2>
        <div class="row">
            <div class="col-xs-2"><strong>Name</strong></div>
            <div class="col-xs-10"><p>{{ $user->account->present()->name() }}</p></div>
        </div>
        <div class="row">
            <div class="col-xs-2"><strong>Email</strong></div>
            <div class="col-xs-10"><p>{{ $user->account->email }}</p></div>
        </div>
        <div class="row">
            <div class="col-xs-2"><strong>Phone</strong></div>
            <div class="col-xs-10"><p>{{ $user->account->phone }}</p></div>
        </div>
        <div class="row">
            <div class="col-xs-2"><strong>Mobile</strong></div>
            <div class="col-xs-10"><p>{{ $user->account->mobile_phone }}</p></div>
        </div>
    </div>
</div>

<div class="ibox">
    <div class="ibox-content">
        <h2>Preferences</h2>
        <div class="row">
            <div class="col-xs-3"><strong>Auto-ship Packages?</strong></div>
            <div class="col-xs-9">
                <p>{!! $user->account->autoship ? '<span class="label label-primary">Yes</span>' : '<span class="label label-danger">No</span>' !!}</p>
                @include('user_profile.client._autoship_notice')
            </div>
        </div>
    </div>
</div>

<div class="ibox">
    <div class="ibox-content">
        <h2>Address</h2>
        <p>{!! $user->account->present()->address() !!}</p>
    </div>
</div>
@stop
