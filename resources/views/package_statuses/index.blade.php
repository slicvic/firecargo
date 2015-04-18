@extends('layouts.members.index')

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
<th>Actions</th>
@stop

@section('tbody')
    <?php foreach ($statuses as $status): ?>
       <tr>
            <td>{{ $status->id }}</td>
            <td>{{ $status->name }}</td>
            <td>
                <a href="/package-statuses/edit/{{ $status->id }}" class="btn-flat icon"><i class="fa fa-pencil"></i></a>
                @if ($status->site_id == Auth::user()->site_id)
                    <a onclick="if (!confirm('Are you sure you want to delete this item?')) return false;" href="/package-statuses/delete/{{ $status->id }}" class="btn-flat icon"><i class="fa fa-times"></i></a>
                @endif
            </td>
       </tr>
    <?php endforeach; ?>
@stop

