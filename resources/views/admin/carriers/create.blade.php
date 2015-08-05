@extends('admin.layouts.page')

@section('title', 'Create Carrier')

@section('subtitle')
<ol class="breadcrumb">
    <li>
        <a href="/carriers">Carriers</a>
    </li>
    <li class="active">
        <strong>Create</strong>
    </li>
</ol>
@stop

@section('page_content')
    @include('admin.carriers._form', ['action' => 'store'])
@stop
