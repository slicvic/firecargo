@extends('admin.layouts.page')

@section('title', 'Add New Account')

@section('subtitle')
<ol class="breadcrumb">
    <li>
        <a href="/accounts">Accounts</a>
    </li>
    <li class="active">
        <strong>Create</strong>
    </li>
</ol>
@stop

@section('page_content')
    @include('admin.accounts._form', ['action' => 'store'])
@stop
