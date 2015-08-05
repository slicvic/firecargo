@extends('admin.layouts.page')

@section('title', 'Your Company Profile')
@section('subtitle', 'Manage Your Company Profile')

@section('page_content')
<div class="row">
    <div class="col-md-4">
        <div class="ibox">
            <div class="ibox-content text-center">
                <h1>{{ "$company->name ($company->shortname)" }}</h1>
                <div id="logo-container" class="m-b-sm">
                    <img class="img-circle" src="{{ $company->present()->logoUrl('md') }}" style="width:100px;height:100px">
                </div>
                <button type="button" id="edit-logo-btn" class="btn btn-link btn-block"><i class="fa fa-pencil"></i> Edit Logo</button>
                <div class="list-group">
                    <a href="/company/edit" class="btn btn-block btn-primary">Edit Company Profile</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        @yield('company_profile_content')
    </div>
</div>

<script src="/assets/plugins/dropzone/dropzone.min.js"></script>
<script src="/assets/admin/js/company-profile.js"></script>
@stop
