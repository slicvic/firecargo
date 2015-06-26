@extends('layouts.admin.index')

@section('icon', 'info-circle')
@section('title', 'Package Statuses')

@section('actions')
<a href="/package-statuses/create" class="btn-flat primary">
    <i class="fa fa-plus"></i> New
</a>
@stop

@section('thead')
<th>ID</th>
<th>Name</th>
<th>Color</th>
<th>Default?</th>
<th>Action</th>
@stop

@section('tbody')
    <?php foreach ($statuses as $status): ?>
       <tr>
            <td>{{ $status->id }}</td>
            <td>{{ $status->name }}</td>
            <td><span class="label label-default" style="background:{{ $status->color }}">{{ $status->color }}</span></td>
            <td>{!! $status->is_default ? '<i class="fa fa-check"></i>' : '' !!}</td>
            <td>
                <a href="/package-statuses/edit/{{ $status->id }}" class="btn-flat icon"><i class="fa fa-pencil"></i></a>
                <a href="/package-statuses/delete/{{ $status->id }}" class="btn-flat icon delete-btn"><i class="fa fa-times"></i></a>
            </td>
       </tr>
    <?php endforeach; ?>
@stop

