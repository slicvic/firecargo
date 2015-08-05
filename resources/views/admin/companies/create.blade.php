@extends('admin.layouts.page')

@section('title', 'Create Company')

@section('subtitle')
<ol class="breadcrumb">
    <li>
        <a href="/companies">Companies</a>
    </li>
    <li class="active">
        <strong>Create</strong>
    </li>
</ol>
@stop

@section('page_content')
    @include('admin.companies._form', ['action' => 'store'])
@stop
