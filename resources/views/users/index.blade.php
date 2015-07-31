@extends('layouts.admin.page.index')

@section('icon', 'group')
@section('title', 'Users')
@section('subtitle', 'Manage User Users')

@section('actions')
    <a href="/users/create" class="btn btn-primary"><i class="fa fa-plus"></i> Add New User</a>
@stop

@section('thead')
    <th>ID</th>
    <th>Company</th>
    <th>Name</th>
    <th>Email</th>
    <th>Role</th>
    <th>Active</th>
    <th>Action</th>
@stop

@section('tbody')
    @foreach ($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->company->name }}</td>
            <td>{{ $user->present()->fullname() }}</td>
            <td>{{ $user->email }}</td>
            <td>{!! $user->present()->role() !!}</td>
            <td>{!! $user->active ? '<span class="badge badge-primary">Yes</span>' : '<span class="badge badge-danger">No</span>' !!}</td>
            <td><a href="/users/edit/{{ $user->id }}" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit</a></td>
        </tr>
    @endforeach
@stop
