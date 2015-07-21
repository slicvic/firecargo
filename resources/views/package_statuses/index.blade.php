@extends('layouts.admin.page.index')

@section('icon', 'info-circle')
@section('title', 'Package Statuses')
@section('subtitle', 'Manage Package Statuses')

@section('actions')
    <a href="/package-statuses/create" class="btn btn-primary"><i class="fa fa-plus"></i> Create New Status</a>
@stop

@section('thead')
    <th>ID</th>
    <th>Name</th>
    <th>Default?</th>
    <th>Action</th>
@stop

@section('tbody')
    @foreach ($statuses as $status)
       <tr>
            <td>{{ $status->id }}</td>
            <td>{{ $status->name }}</td>
            <td>{!! $status->default ? '<i class="fa fa-check text-navy"></i>' : '' !!}</td>
            <td>
                <div class="btn-group">
                    <a href="/package-statuses/edit/{{ $status->id }}" class="btn-white btn btn-sm">Edit</a>
                    <a href="/package-statuses/delete/{{ $status->id }}" class="btn-delete btn-white btn btn-sm">Delete</a>
                </div>
            </td>
       </tr>
    @endforeach
@stop

