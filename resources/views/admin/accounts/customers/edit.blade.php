@extends('admin.layouts.page')

@section('title', 'Edit Customer # ' . $account->id)

@section('subtitle')
<ol class="breadcrumb">
    <li>
        <a href="/accounts/customers">Customers</a>
    </li>
    <li class="active">
        <strong>Edit</strong>
    </li>
</ol>
@stop

@section('page_content')
    @include('admin.accounts.customers._form', ['action' => $account->id . '/update'])
@stop
