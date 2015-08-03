@extends('layouts.admin.page.index')

@section('icon', 'building-o')
@section('title', 'Sites')
@section('subtitle', 'Manage Sites')

@section('actions')
    <a href="/site/create" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Site</a>
@stop

@section('thead')
    <th>ID</th>
    <th>Company</th>
    <th>Name</th>
    <th>Action</th>
@stop

@section('tbody')
     @foreach ($sites as $site)
        <tr>
            <td>{{ $site->id }}</td>
            <td>{{ $site->company->name }}</td>
            <td>{{ $site->name }}</td>
            <td>
                <div class="btn-group">
                    <a href="/site/{{ $site->id }}/edit" class="btn-white btn btn-sm"><i class="fa fa-pencil"></i> Edit</a>
                </div>
            </td>
        </tr>
    @endforeach
@stop

