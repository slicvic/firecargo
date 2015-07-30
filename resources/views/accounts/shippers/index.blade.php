@extends('layouts.admin.page.index')

@section('icon', 'group')
@section('title', 'Shippers')
@section('subtitle', 'Manage Your Shippers')

@section('actions')
    <a href="/shippers/create" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Shipper</a>
@stop

@section('thead')
    <th>ID</th>
    <th>Name</th>
    <th>Action</th>
@stop

@section('tbody')
    @foreach ($accounts as $account)
        <tr>
            <td>{{ $account->id }}</td>
            <td>{{ $account->name }}</td>
            <td><a href="/shippers/edit/{{ $account->id }}" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit</a></td>
        </tr>
    @endforeach
@stop
