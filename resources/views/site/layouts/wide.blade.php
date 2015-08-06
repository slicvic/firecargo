@extends('site.layouts.master')

@section('content')
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        @include('site.layouts._header_logo')
        <br>
        {!! Flash::getBootstrap() !!}
        @yield('wide_content')
        <br>
        @include('site.layouts._footer')
    </div>
</div>
@stop
