@extends('layouts.admin.index')

@section('icon', 'group')
@section('title', 'Accounts')

@section('actions')
<a href="/accounts/create" class="btn-flat primary">
    <i class="fa fa-plus"></i> New
</a>
@stop

@section('thead')
<th>ID</th>
<th>Site Name</th>
<th>Business Name</th>
<th>First Name</th>
<th>Last Name</th>
<th>Email</th>
<th>Phone</th>
<th>Mobile</th>
<th>Groups</th>
<th>Action</th>
@stop

@section('script')
$(function() {
    $('table').dataTable({
        //'aaSorting': [[ 0, 'desc' ]],
         'processing': true,
        'serverSide': true,
        'ajax': '/accounts/ajax-datatable',
    });
});
@stop
