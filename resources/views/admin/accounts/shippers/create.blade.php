@extends('admin.layouts.page')

@section('title', 'Add New Shipper')

@section('subtitle')
<ol class="breadcrumb">
    <li>
        <a href="/accounts/shippers">Shippers</a>
    </li>
    <li class="active">
        <strong>Create</strong>
    </li>
</ol>
@stop

@section('page_content')
    @include('admin.accounts.shippers._form', ['action' => 'store'])
@stop
