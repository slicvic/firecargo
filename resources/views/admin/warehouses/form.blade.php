@extends('admin.layouts.page')

@section('title')
    {{ $warehouse->exists ? 'Edit Warehouse # ' . $warehouse->id : 'Create New Warehouse' }}
@stop

@section('subtitle')
<ol class="breadcrumb">
    <li>
        <a href="/warehouses">Warehouses</a>
    </li>
    @if ($warehouse->exists)
        <li>
            <a href="/warehouse/{{ $warehouse->id }}/show">Details</a>
        </li>
    @endif
    <li class="active">
        <strong>{{ $warehouse->exists ? 'Edit' : 'Create' }}</strong>
    </li>
</ol>
@stop

@section('actions')
    @include('admin.warehouses._form_actions')
@stop

@section('page_content')
<form id="warehouse-form" action="/warehouse/{{ $warehouse->exists ? $warehouse->id . '/update' : 'store' }}" method="post" class="">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-md-9">
                @include('admin.warehouses._form_packages')
            </div>
            <div class="col-md-3">
                @include('admin.warehouses._form_details')
            </div>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-content text-right">
                @include('admin.warehouses._form_actions')
            </div>
        </div>
    </div>
</div>
<script src="/assets/admin/js/warehouse-form.js"></script>
@stop
