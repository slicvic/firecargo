@extends('layouts.admin.page.index')

@section('title', 'Users')
@section('subtitle', 'Manage User Users')

@section('actions')
    <a href="/user/create" class="btn btn-primary"><i class="fa fa-plus"></i> Add New User</a>
@stop

@section('thead')
    <th>ID</th>
    <th>Company</th>
    <th>Name</th>
    <th>Email</th>
    <th>Role</th>
    <th>Active</th>
    <th>Last Login</th>
    <th>Logins</th>
    <th>Created</th>
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
            <td>{!! $user->present()->active() !!}</td>
            <td>{{ $user->present()->lastLogin() }}</td>
            <td>{{ $user->logins }}</td>
            <td>{{ $user->present()->createdAt() }}</td>
            <td><a href="/user/{{ $user->id }}/edit" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit</a></td>
        </tr>
    @endforeach
@stop
