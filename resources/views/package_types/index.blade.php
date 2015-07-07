@extends('layouts.admin.model.index')

@section('icon', 'info-circle')
@section('title', 'Package Types')
@section('subtitle', 'Manage Package Types')

@section('actions')
    <a href="/package-types/create" class="btn btn-primary"><i class="fa fa-plus"></i> Create New</a>
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
                @if ($type->company_id == Auth::user()->company_id)
                    <div class="btn-group">
                        <a href="/package-types/edit/{{ $type->id }}" class="btn-white btn btn-sm">Edit</a>
                        <a href="/package-types/delete/{{ $type->id }}" class="btn-white btn btn-sm">Delete</a>
                    </div>
                @endif
            </td>
       </tr>
    @endforeach
</tbody>
@stop
