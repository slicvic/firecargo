@extends('layouts.admin.page.index')

@section('title', 'Shippers')
@section('subtitle', 'Manage Your Shippers')

@section('actions')
    <a href="/shipper/create" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Shipper</a>
@stop

@section('thead')
    @if ($isAdminUser)
        <th>Company</th>
    @endif
    <th>ID</th>
    <th>Name</th>
    <th>Address</th>
    <th>Action</th>
@stop

@section('tbody')
    @foreach ($accounts as $account)
        <tr>
            @if ($isAdminUser)
                <td>{{ $account->company->name }}</td>
            @endif
            <td>{{ $account->id }}</td>
            <td>{{ $account->name }}</td>
            <td>{!! $account->present()->address() !!}</td>
            <td><a href="/shipper/{{ $account->id }}/edit" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit</a></td>
        </tr>
    @endforeach
@stop
