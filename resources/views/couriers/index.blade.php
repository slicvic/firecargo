@extends('layouts.members.index')

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
<th>Actions</th>
@stop

@section('tbody')
    @foreach ($couriers as $courier)
       <tr>
            <td>{{ $courier->id }}</td>
            <td>{{ $courier->name }}</td>
            <td>
                <a href="/couriers/edit/{{ $courier->id }}" class="btn-flat icon"><i class="fa fa-pencil"></i></a>
                @if ((int) $courier->site_id == (int) Auth::user()->site_id)
                    <a onclick="if (!confirm('Are you sure you want to delete this item?')) return false;" href="/couriers/delete/{{ $courier->id }}" class="btn-flat icon"><i class="fa fa-times"></i></a>
                @endif
            </td>
       </tr>
    @endforeach
@stop
