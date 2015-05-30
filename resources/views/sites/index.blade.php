@extends('layouts.members.index')

@section('icon', 'building-o')
@section('title', 'Sites')

@section('actions')
<a href="/sites/create" class="btn-flat primary">
    <i class="fa fa-plus"></i> New
</a>
@stop

@section('thead')
<th>ID</th>
<th>Name</th>
<th>Display Name</th>
<th>Company</th>
<th>Actions</th>
@stop

@section('tbody')
     @foreach ($sites as $site)
        <tr>
            <td>{{ $site->id }}</td>
            <td>{{ $site->name }}</td>
            <td>{{ $site->display_name }}</td>
            <td>{{ ($site->company) ? $site->company->name : '' }}</td>
            <td><a href="/sites/edit/{{ $site->id }}" class="btn btn-flat icon"><i class="fa fa-pencil"></i></a></td>
        </tr>
    @endforeach
@stop

