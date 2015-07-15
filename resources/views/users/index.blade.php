@extends('layouts.admin.page.index')

@section('icon', 'group')
@section('title', 'Accounts')
@section('subtitle', 'Manage User Accounts')

@section('actions')
    <a href="/accounts/create" class="btn btn-primary"><i class="fa fa-plus"></i> Create New Account</a>
@stop

@section('thead')
    <th>ID</th>
    @if (Auth::user()->isAdmin()) {!! '<th>Master</th>' !!} @endif
    <th>Company</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Mobile</th>
    <th>Type</th>
    <th>Login Allowed?</th>
    <th>Action</th>
@stop

@section('script')
<script>
    jQuery(function() {
        $('table').dataTable({
            //'aaSorting': [[ 0, 'desc' ]],
            'processing': true,
            'serverSide': true,
            'ajax': '/accounts/ajax-datatable',
        });
    });
</script>
@stop
