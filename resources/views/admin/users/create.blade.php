@extends('admin.layouts.page')

@section('title', 'Add New User')

@section('subtitle')
<ol class="breadcrumb">
    <li>
        <a href="/users">Users</a>
    </li>
    <li class="active">
        <strong>Create</strong>
    </li>
</ol>
@stop

@section('page_content')
    @include('admin.users._form', ['action' => 'store'])
@stop
