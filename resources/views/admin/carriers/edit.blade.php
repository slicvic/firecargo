@extends('admin.layouts.page')

@section('title', 'Edit Carrier # ' . $carrier->id)

@section('subtitle')
<ol class="breadcrumb">
    <li>
        <a href="/carriers">Carriers</a>
    </li>
    <li class="active">
        <strong>Edit</strong>
    </li>
</ol>
@stop

@section('page_content')
    @include('admin.carriers._form', ['action' => $carrier->id . '/update'])
@stop
