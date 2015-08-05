@extends('admin.layouts.page')

@section('title', 'Edit Shipper # ' . $account->id)

@section('subtitle')
<ol class="breadcrumb">
    <li>
        <a href="/accounts/shippers">Shippers</a>
    </li>
    <li class="active">
        <strong>Edit</strong>
    </li>
</ol>
@stop

@section('page_content')
    @include('admin.accounts.shippers._form', ['action' => $account->id . '/update'])
@stop
