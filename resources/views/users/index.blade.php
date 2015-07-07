@extends('layouts.admin.model.index')

@section('icon', 'group')
@section('title', 'Accounts')
@section('subtitle', 'Manage User Accounts')

@section('actions')
    <a href="/users/create" class="btn btn-primary"><i class="fa fa-plus"></i> Create New Account</a>
@stop

@section('thead')
    <th>ID</th>
    <th>Company Name</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Mobile</th>
    <th>Group</th>
    <th>Action</th>
@stop

@section('script')
    jQuery(function() {
        $('table').dataTable({
            //'aaSorting': [[ 0, 'desc' ]],
            'processing': true,
            'serverSide': true,
            'ajax': '/users/ajax-datatable',
        });
    });
@stop
