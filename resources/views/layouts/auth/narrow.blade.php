@extends('layouts.auth.master')

@section('content')
<div class="passwordBox animated fadeInDown">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">{!! env('APP_TEXT_LOGO') !!}</h1>
            <br>
            {!! Flash::getBootstrap() !!}
            @yield('narrow_content')
        </div>
    </div>
    <br>
    @include('layouts.auth._footer')
</div>
@stop
