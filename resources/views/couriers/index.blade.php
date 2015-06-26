@extends('layouts.admin.index')

@section('icon', 'truck')
@section('title', 'Couriers')

@section('actions')
<a href="/couriers/create" class="btn-flat primary">
    <i class="fa fa-plus"></i> New
</a>
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
                    <a href="/couriers/edit/{{ $courier->id }}" class="btn-flat icon"><i class="fa fa-pencil"></i></a>
                    <a href="/couriers/delete/{{ $courier->id }}" class="btn-flat icon delete-btn"><i class="fa fa-times"></i></a>
                @endif
            </td>
       </tr>
    @endforeach
@stop
