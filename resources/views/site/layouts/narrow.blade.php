@extends('site.layouts.master')

@section('content')
<div class="passwordBox animated fadeInDown">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">{!! env('APP_HTML_LOGO') !!}</h1>
            <br>
            {!! Flash::getBootstrap() !!}
            @yield('narrow_content')
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12 text-center">
           &copy; {{ date('Y') }}, {{ env('APP_COMPANY_NAME') }}
        </div>
    </div>
</div>
@stop
