@extends('layouts.admin.page.index')

@section('title', 'Package Types')
@section('subtitle', 'Manage Package Types')

@section('actions')
    <a href="/package-type/create" class="btn btn-primary"><i class="fa fa-plus"></i> Add New</a>
@stop

@section('thead')
    <th>ID</th>
    <th>Name</th>
    <th>Action</th>
@stop

@section('tbody')
    @foreach ($types as $type)
       <tr>
            <td>{{ $type->id }}</td>
            <td>{{ $type->name }}</td>
            <td>
                <div class="btn-group">
                    <a href="/package-type/{{ $type->id }}/edit" class="btn-white btn btn-sm">Edit</a>
                    <a href="/package-type/{{ $type->id }}/delete" class="delete-record-btn btn-white btn btn-sm">Delete</a>
                </div>
            </td>
       </tr>
    @endforeach
</tbody>
@stop
