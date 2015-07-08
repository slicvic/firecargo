@extends('layouts.admin.model.index')

@section('icon', 'building-o')
@section('title', 'Companies')
@section('subtitle', 'Manage Companies')

@section('actions')
    <a href="/companies/create" class="btn btn-primary"><i class="fa fa-plus"></i> Create New Company</a>
@stop

@section('thead')
    <th>ID</th>
    <th>Name</th>
    <th>Code</th>
    <th>Action</th>
@stop

@section('tbody')
    @foreach ($companies as $company)
       <tr>
            <td>{{ $company->id }}</td>
            <td>{{ $company->name }}</td>
            <td>{{ $company->code }}</td>
            <td>
                <div class="btn-group">
                    <a href="/companies/edit/{{ $company->id }}" class="btn-white btn btn-sm"><i class="fa fa-pencil"></i> Edit</a>
                </div>
            </td>
       </tr>
    @endforeach
@stop
