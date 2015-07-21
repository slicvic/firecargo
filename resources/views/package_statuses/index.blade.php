@extends('layouts.admin.page.index')

@section('icon', 'info-circle')
@section('title', 'Package Statuses')
@section('subtitle', 'Manage Package Statuses')

@section('actions')
    <a href="/package-statuses/create" class="btn btn-primary"><i class="fa fa-plus"></i> Create New Status</a>
@stop

@section('thead')
    @if (Auth::user()->isAdmin())<th>Master</th>@endif
    <th>ID</th>
    <th>Name</th>
    <th>Default?</th>
    <th>Action</th>
@stop

@section('tbody')
    @foreach ($statuses as $status)
       <tr>
            @if (Auth::user()->isAdmin())<td>{{ $status->company ? $status->company->name : 'N/A' }}</td>@endif
            <td>{{ $status->id }}</td>
            <td>{{ $status->name }}</td>
            <td>{!! $status->default ? '<i class="fa fa-check"></i>' : '' !!}</td>
            <td>
                <div class="btn-group">
                    <a href="/package-statuses/edit/{{ $status->id }}" class="btn-white btn btn-sm">Edit</a>
                    <a href="/package-statuses/delete/{{ $status->id }}" class="btn-delete btn-white btn btn-sm">Delete</a>
                </div>
            </td>
       </tr>
    @endforeach
@stop

