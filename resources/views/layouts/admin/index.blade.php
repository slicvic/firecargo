@extends('layouts.admin.master')

@section('content')
<div class="row">
    <h3><i class="fa fa-@yield('icon')"></i> @yield('title')</h3>
    <hr>
</div>

<div class="row filter-block">
    <div class="col-md-12">
        @yield('actions')
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <table class="datatable table table-striped">
            <thead>
                <tr>
                    @yield('thead')
                </tr>
            </thead>
            <tbody>
                @yield('tbody')
            </tbody>
        </table>
    </div>
</div>

<script>
    @yield('script', "$(function() { $('table').dataTable(); });")
</script>
@stop
