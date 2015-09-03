@extends('website.layouts.master')

@section('content')
<div class="passwordBox animated fadeInDown">
    <div class="row">
        <div class="col-md-12">
            @include('website.layouts._header_logo')
            <br>
            {!! Flash::render('bootstrap') !!}
            @yield('narrow_content')
        </div>
    </div>
    <br>
    @include('website.layouts._footer')
</div>
@stop
