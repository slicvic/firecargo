@extends('layouts.admin.index')

@section('icon', 'building-o')
@section('title', 'Companies')

@section('actions')
<a href="/companies/create" class="btn-flat primary">
    <i class="fa fa-plus"></i> New
</a>
@stop

@section('thead')
<th>ID</th>
<th>Name</th>
<th>Action</th>
@stop

@section('tbody')
    @foreach ($companies as $company)
       <tr>
            <td>{{ $company->id }}</td>
            <td>{{ $company->name }}</td>
            <td><a href="/companies/edit/{{ $company->id }}" class="btn btn-flat icon"><i class="fa fa-pencil"></i></a></td>
       </tr>
    @endforeach
@stop
