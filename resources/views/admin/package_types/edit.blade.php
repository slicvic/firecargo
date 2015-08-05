@extends('admin.layouts.page')

@section('title', 'Edit Package Type # ' . $type->id)

@section('subtitle')
<ol class="breadcrumb">
    <li>
        <a href="/package-types">Package Types</a>
    </li>
    <li class="active">
        <strong>Edit</strong>
    </li>
</ol>
@stop

@section('page_content')
    @include('admin.package_types._form', ['action' => $type->id . '/update'])
@stop

