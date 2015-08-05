@extends('admin.layouts.pages.company_profile')

@section('company_profile_content')
<div class="ibox">
    <div class="ibox-content">
        <h2>Company Info</h2>
        <div class="row">
            <div class="col-xs-2"><strong>Tel</strong></div>
            <div class="col-xs-10"><p>{{ $company->phone }}</p></div>
        </div>
        <div class="row">
            <div class="col-xs-2"><strong>Fax</strong></div>
            <div class="col-xs-10"><p>{{ $company->fax }}</p></div>
        </div>
        <div class="row">
            <div class="col-xs-2"><strong>Email</strong></div>
            <div class="col-xs-10"><p>{{ $company->email }}</p></div>
        </div>
        <div class="row">
            <div class="col-xs-2"><strong>Address</strong></div>
            <div class="col-xs-10"><p>{!! $company->present()->address() !!}</p></div>
        </div>
    </div>
</div>
@stop
