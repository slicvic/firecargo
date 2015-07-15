@extends('layouts.admin.page')

@section('title', 'My Profile')
@section('subtitle', 'Your Profile & Preferences')

@section('page_content')
<div class="row">
    <div class="col-md-4">
       @include('user_profile._nav')
    </div>
    <div class="col-md-8">
        @yield('user_profile_content')
    </div>
</div>

<script src="/assets/vendor/dropzone/dropzone.min.js"></script>
<script src="/assets/admin/js/pages/user-profile.js"></script>
@stop
