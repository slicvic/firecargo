@extends('admin.layouts.page')

@section('title', 'Add New Customer')

@section('subtitle')
<ol class="breadcrumb">
    <li>
        <a href="/accounts/customers">Customers</a>
    </li>
    <li class="active">
        <strong>Create</strong>
    </li>
</ol>
@stop

@section('page_content')
    @include('admin.accounts.customers._form', ['action' => 'store'])
@stop
