<?php $isAdmin = Auth::user()->isAdmin(); ?>

@extends('layouts.admin.model.index')

@section('icon', 'building-o')
@section('title', 'Sites')
@section('subtitle', 'Manage Sites')

@section('actions')
    @if ($isAdmin)
        <a href="/sites/create" class="btn btn-primary"><i class="fa fa-plus"></i> Create New Site</a>
    @endif
@stop

@section('thead')
    <th>ID</th>
    @if ($isAdmin)<th>Master</th>@endif
    <th>Name</th>
    <th>Display Name</th>
    <th>Action</th>
@stop

@section('tbody')
     @foreach ($sites as $site)
        <tr>
            <td>{{ $site->id }}</td>
            @if ($isAdmin)<td>{{ ($site->company) ? $site->company->name : '' }}</td>@endif
            <td>{{ $site->name }}</td>
            <td>{{ $site->display_name }}</td>
            <td>
                <div class="btn-group">
                    <a href="/sites/edit/{{ $site->id }}" class="btn-white btn btn-sm"><i class="fa fa-pencil"></i> Edit</a>
                </div>
            </td>
        </tr>
    @endforeach
@stop

