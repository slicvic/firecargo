@extends('admin.layouts.page')

@section('title', 'Edit Company # ' . $company->id)

@section('subtitle')
<ol class="breadcrumb">
    <li>
        <a href="/companies">Companies</a>
    </li>
    <li class="active">
        <strong>Edit</strong>
    </li>
</ol>
@stop

@section('page_content')
    @include('admin.companies._form', ['action' => $company->id . '/update'])
@stop
