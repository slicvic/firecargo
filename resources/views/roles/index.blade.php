@extends('layouts.admin.model.index')

@section('icon', 'male')
@section('title', 'Roles')
@section('subtitle', 'Manage Account Roles')

@section('actions')
    <a href="/roles/create" class="btn btn-primary"><i class="fa fa-plus"></i> Create New Role</a>
@stop

@section('thead')
    <th>ID</th>
    <th>Name</th>
    <th>Description</th>
    <th>Action</th>
@stop

@section('tbody')
     @foreach ($roles as $role)
        <tr>
            <td>{{ $role->id }}</td>
            <td>{{ $role->name }}</td>
            <td>{{ $role->description }}</td>
            <td>
                <div class="btn-group">
                    <a href="/roles/edit/{{ $role->id }}" class="btn-white btn btn-sm">Edit</a>
                    <a href="/roles/delete/{{ $role->id }}" class="btn-delete btn-white btn btn-sm">Delete</a>
                </div>
            </td>
        </tr>
    @endforeach
@stop

