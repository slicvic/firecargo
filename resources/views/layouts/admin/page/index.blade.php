@extends('layouts.admin.page')

@section('page_content')
<div class="ibox float-e-margins">
    <div class="ibox-content">
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
@stop


