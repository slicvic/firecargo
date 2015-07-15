@extends('layouts.admin.page.index')

@section('icon', 'building-o')
@section('title', 'Sites')
@section('subtitle', 'Manage Sites')

@section('actions')
    <a href="/sites/create" class="btn btn-primary"><i class="fa fa-plus"></i> Create New Site</a>
@stop

@section('thead')
    <th>ID</th>
    <th>Master</th>
    <th>Name</th>
    <th>Action</th>
@stop

@section('tbody')
     @foreach ($sites as $site)
        <tr>
            <td>{{ $site->id }}</td>
            <td>{{ ($site->company) ? $site->company->name : '' }}</td>
            <td>{{ $site->name }}</td>
            <td>
                <div class="btn-group">
                    <a href="/sites/edit/{{ $site->id }}" class="btn-white btn btn-sm"><i class="fa fa-pencil"></i> Edit</a>
                </div>
            </td>
        </tr>
    @endforeach
@stop

