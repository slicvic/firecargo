@extends('admin.layouts.page')

@section('title', 'Edit Account # ' . $account->id)

@section('subtitle')
<ol class="breadcrumb">
    <li>
        <a href="/accounts">Accounts</a>
    </li>
    <li class="active">
        <strong>Edit</strong>
    </li>
</ol>
@stop

@section('page_content')
    @include('admin.accounts._form', ['action' => $account->id . '/update'])
@stop
