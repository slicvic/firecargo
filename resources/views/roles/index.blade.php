@extends('layouts.members.index')

@section('icon', 'male')
@section('title', 'Roles')

@section('actions')
<a href="/roles/create" class="btn-flat primary">
    <i class="fa fa-plus"></i> New
</a>
@stop

@section('thead')
<th>ID</th>
<th>Name</th>
<th>Description</th>
<th>Actions</th>
@stop

@section('tbody')
     @foreach ($roles as $role)
        <tr>
            <td>{{ $role->id }}</td>
            <td>{{ $role->name }}</td>
            <td>{{ $role->description }}</td>
            <td><a href="/roles/edit/{{ $role->id }}" class="btn btn-flat icon"><i class="fa fa-pencil"></i></a></td>
        </tr>
    @endforeach
@stop

