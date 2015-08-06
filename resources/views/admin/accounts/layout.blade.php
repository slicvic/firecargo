@extends('admin.layouts.page')

@section('title', 'Accounts')
@section('subtitle', 'Manage Your Accounts')
@section('actions')
<div class="btn-group">
    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" aria-expanded="false"><i class="fa fa-plus"></i> Add New <span class="caret"></span></button>
    <ul class="dropdown-menu">
        <li><a href="/accounts/customer/create">Customer</a></li>
        <li><a href="/accounts/shipper/create">Shipper</a></li>
    </ul>
</div>
@stop

@section('page_content')
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-group btn-group-lg" role="group" aria-label="Large button group">
                    <a href="/accounts/customers" class="btn {{ Request::is('accounts/customers') ? 'btn-primary' : 'btn-white' }}">Customers</a>
                    <a href="/accounts/shippers" class="btn {{ Request::is('accounts/shippers') ? 'btn-primary' : 'btn-white' }}">Shippers</a>
                </div>
            </div>
        </div>
        <br>
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <h2>@yield('accounts_title')</h2>
                <hr>
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

    </div>
</div>
@stop


