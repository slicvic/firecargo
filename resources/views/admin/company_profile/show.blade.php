@extends('admin.company_profile.layout')

@section('company_profile_content')
<div class="ibox">
    <div class="ibox-content">
        <h2>Company Information</h2>
        <div class="row">
            <div class="col-xs-2"><strong>Phone</strong></div>
            <div class="col-xs-10"><p>{{ $company->phone }}&nbsp;</p></div>
        </div>
        <div class="row">
            <div class="col-xs-2"><strong>Email</strong></div>
            <div class="col-xs-10"><p>{{ $company->email }}&nbsp;</p></div>
        </div>
        <div class="row">
            <div class="col-xs-2"><strong>Billing Address</strong></div>
            <div class="col-xs-10"><p>{!! $company->present()->address('billing') !!}&nbsp;</p></div>
        </div>
    </div>
</div>
@stop
