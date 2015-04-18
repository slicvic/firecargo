@extends('layouts.members.master')

@section('content')
<div class="row">
    <h3><i class="fa fa-@yield('icon')"></i> @yield('title')</h3>
    <hr>
</div>

<div class="row">
    <div class="col-md-12">
        @yield('form')
    </div>
</div>
@stop
