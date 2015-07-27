@extends('layouts.admin.page.index')

@section('icon', 'group')
@section('title', 'Accounts')
@section('subtitle', 'Manage Accounts')

@section('actions')
    <a href="/accounts/create" class="btn btn-primary"><i class="fa fa-plus"></i> Create New Account</a>
@stop

@section('thead')
    <th>ID</th>
    <th>Name</th>
    <th>Type</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Mobile</th>
    <th>Action</th>
@stop

@section('tbody')
    @foreach ($accounts as $account)
        <tr>
            <td>{{ $account->id }}</td>
            <td>{{ $account->name }}</td>
            <td>{!! $account->present()->type() !!}</td>
            <td>{{ $account->email }}</td>
            <td>{{ $account->phone }}</td>
            <td>{{ $account->mobile_phone }}</td>
            <td><a href="/accounts/edit/{{ $account->id }}" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit</a></td>
        </tr>
    @endforeach
@stop

@section('script')
<script>
    jQuery(function() {
        /*$('table').dataTable({
            'aaSorting': [[ 0, 'desc' ]],
            'processing': true,
            'serverSide': true,
            'ajax': '/accounts/ajax-datatable',
        });*/
    });
</script>
@stop
