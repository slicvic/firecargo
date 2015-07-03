@extends('layouts.admin.model.index')

@section('icon', 'group')
@section('title', 'Accounts')
@section('subtitle', 'Manage User Accounts')

@section('actions')
    <a href="/accounts/create" class="btn btn-primary"><i class="fa fa-plus"></i> Create New Role</a>
@stop

@section('thead')
    <th>ID</th>
    <th>Site</th>
    <th>Company</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Mobile</th>
    <th>Groups</th>
    <th>Action</th>
@stop

@section('script')
    jQuery(function() {
        $('table').dataTable({
            //'aaSorting': [[ 0, 'desc' ]],
            'processing': true,
            'serverSide': true,
            'ajax': '/accounts/ajax-datatable',
        });
    });
@stop
