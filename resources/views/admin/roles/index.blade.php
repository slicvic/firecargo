@extends('admin.layouts.index')

@section('title', 'Roles')
@section('subtitle', 'Manage Account Roles')

@section('actions')
@stop

@section('thead')
    <th>ID</th>
    <th>Name</th>
    <th>Description</th>
@stop

@section('tbody')
     @foreach ($roles as $role)
        <tr>
            <td>{{ $role->id }}</td>
            <td>{{ $role->name }}</td>
            <td>{{ $role->description }}</td>
        </tr>
    @endforeach
@stop

