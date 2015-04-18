@extends('layouts.members.index')

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
<th>Company</th>
<th>First Name</th>
<th>Last Name</th>
<th>Email</th>
<th>Phone</th>
<th>Mobile</th>
<th>Groups</th>
<th>Actions</th>
@stop

@section('script')
$(function() {
    $('table').dataTable({
        //'aaSorting': [[ 0, 'desc' ]],
         'processing': true,
        'serverSide': true,
        'ajax': '/accounts/datatable',
    });
});
@stop
