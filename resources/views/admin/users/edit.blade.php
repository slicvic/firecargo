@extends('admin.layouts.page')

@section('title', 'Edit User # ' . $user->id)

@section('subtitle')
<ol class="breadcrumb">
    <li>
        <a href="/users">Users</a>
    </li>
    <li class="active">
        <strong>Edit</strong>
    </li>
</ol>
@stop

@section('page_content')
    @include('admin.users._form', ['action' => $user->id . '/update'])
@stop
