@extends('website.layouts.master')

@section('content')
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        @include('website.layouts._header_logo')
        <br>
        {!! Flash::render('bootstrap') !!}
        @yield('wide_content')
        <br>
        @include('website.layouts._footer')
    </div>
</div>
@stop
