@extends('layouts.auth.master')

@section('content')
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h1 class="text-center">{!! env('APP_HTML_LOGO') !!}</h1>
        <br>
        {!! Flash::getBootstrap() !!}
        @yield('wide_content')
        <br>
        @include('layouts.auth._footer')
        <br>
    </div>
</div>
@stop
