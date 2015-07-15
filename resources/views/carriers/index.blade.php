@extends('layouts.admin.page.index')

@section('icon', 'truck')
@section('title', 'Carriers')
@section('subtitle', 'Manage Carriers')

@section('actions')
    <a href="/carriers/create" class="btn btn-primary"><i class="fa fa-plus"></i> Create New Carrier</a>
@stop

@section('thead')
    <th>ID</th>
    <th>Prefix</th>
    <th>Code</th>
    <th>Name</th>
    <th>Action</th>
@stop

@section('tbody')
    @foreach ($carriers as $carrier)
       <tr>
            <td>{{ $carrier->id }}</td>
            <td>{{ $carrier->prefix }}</td>
            <td>{{ $carrier->code }}</td>
            <td>{{ $carrier->name }}</td>
            <td>
                <div class="btn-group">
                    <a href="/carriers/edit/{{ $carrier->id }}" class="btn-white btn btn-sm">Edit</a>
                    <a href="/carriers/delete/{{ $carrier->id }}" class="btn-delete btn-white btn btn-sm">Delete</a>
                </div>
            </td>
       </tr>
    @endforeach
@stop
