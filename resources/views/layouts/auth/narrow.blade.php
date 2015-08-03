@extends('layouts.auth.master')

@section('content')
<div class="passwordBox animated fadeInDown">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center" style="margin-bottom:30px;">{!! env('APP_NAME_HTML') !!}</h1>
            {!! Flash::getClassic() !!}
            @yield('narrow_content')
        </div>
    </div>
    <hr/>
    <div class="row">
        @include('layouts.auth._footer')
    </div>
</div>
@stop
