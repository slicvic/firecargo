@extends('layouts.admin.model.index')

@section('icon', 'truck')
@section('title', 'Couriers')
@section('subtitle', 'Manage Couriers')

@section('actions')
    <a href="/couriers/create" class="btn btn-primary"><i class="fa fa-plus"></i> Create New Courier</a>
@stop

@section('thead')
    <th>ID</th>
    <th>Name</th>
    <th>Action</th>
@stop

@section('tbody')
    @foreach ($couriers as $courier)
       <tr>
            <td>{{ $courier->id }}</td>
            <td>{{ $courier->name }}</td>
            <td>
                @if ($courier->site_id == Auth::user()->site_id)
                    <div class="btn-group">
                        <a href="/couriers/edit/{{ $courier->id }}" class="btn-white btn btn-sm">Edit</a>
                        <a href="/couriers/delete/{{ $courier->id }}" class="btn-white btn btn-sm">Delete</a>
                    </div>
                @endif
            </td>
       </tr>
    @endforeach
@stop
