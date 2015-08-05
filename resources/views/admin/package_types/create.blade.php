@extends('admin.layouts.page')

@section('title', 'Add Package Type')

@section('subtitle')
<ol class="breadcrumb">
    <li>
        <a href="/package-types">Package Types</a>
    </li>
    <li class="active">
        <strong>Create</strong>
    </li>
</ol>
@stop

@section('page_content')
    @include('admin.package_types._form', ['action' => 'store'])
@stop

