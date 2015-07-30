@extends('layouts.admin.master')

@section('content')
<form id="warehouse-edit-form" action="/warehouses/{{ $warehouse->exists ? 'update/' . $warehouse->id : 'store' }}" method="post" class="form-horsizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>{{ $warehouse->exists ? 'Edit Warehouse # ' . $warehouse->id : 'Create Warehouse' }}</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="/warehouses">Warehouses</a>
                </li>
                @if ($warehouse->exists)
                    <li>
                        <a href="/warehouses/show/{{ $warehouse->id }}">Detail</a>
                    </li>
                @endif
                <li class="active">
                    <strong>{{ $warehouse->exists ? 'Edit' : 'Create' }}</strong>
                </li>
            </ol>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                <a class="btn btn-white" href="/warehouses{{ $warehouse->exists ? '/show/' . $warehouse->id : '' }}">Cancel</a>
                <button class="btn btn-primary" data-loading-text="Saving..." type="submit">Save Warehouse</button>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div id="flash-message"></div>
        <div class="row">
            <div class="col-md-9">
                @include('warehouses.edit._section_packages')
            </div>
            <div class="col-md-3">
                @include('warehouses.edit._section_details')
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-content text-right">
                        <a class="btn btn-white" href="/warehouses{{ $warehouse->exists ? '/show/' . $warehouse->id : '' }}">Cancel</a>
                        <button class="btn btn-primary" data-loading-text="Saving..." type="submit">Save Warehouse</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script src="/assets/admin/js/warehouse-edit.js"></script>
@stop
