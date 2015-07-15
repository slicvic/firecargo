@extends('layouts.admin.page')

@section('icon', 'building-o')
@section('title', 'Your Company Profile')
@section('subtitle', 'Manage Your Company Profile')

@section('page_content')
<div class="row">
    <div class="col-md-4">
       @include('company_profile._nav')
    </div>
    <div class="col-md-8">
        @yield('company_profile_content')
    </div>
</div>

<script src="/assets/vendor/dropzone/dropzone.min.js"></script>
<script src="/assets/admin/js/pages/company-profile.js"></script>
@stop
