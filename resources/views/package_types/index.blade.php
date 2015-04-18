@extends('layouts.members.index')

@section('icon', 'info-circle')
@section('title', 'Package Types')

@section('actions')
<a href="/package-types/create" class="btn-flat primary">
    <i class="fa fa-plus"></i> New
</a>
@stop

@section('thead')
<th>ID</th>
<th>Name</th>
<th>Actions</th>
@stop

@section('tbody')
    @foreach ($types as $type)
       <tr>
            <td>{{ $type->id }}</td>
            <td>{{ $type->name }}</td>
            <td><a href="/package-types/edit/{{ $type->id }}" class="btn-flat icon"><i class="fa fa-pencil"></i></a></td>
       </tr>
    @endforeach
</tbody>
@stop
