@extends('layouts.admin.master')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>@yield('title')</h2>
        @yield('subtitle')
    </div>
    <div class="col-sm-8">
        <div class="title-action">
            @yield('actions')
        </div>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            {!! Flash::getHtml() !!}
            @yield('page_content')
        </div>
    </div>
</div>

@yield('script')

@stop
