@extends('admin.layouts.page')

@section('title')
    {{ $shipment->exists ? 'Edit Shipment # ' . $shipment->id : 'Create New Shipment' }}
@stop

@section('subtitle')
<ol class="breadcrumb">
    <li>
        <a href="/shipments">Shipments</a>
    </li>
    @if ($shipment->exists)
        <li>
            <a href="/shipment/{{ $shipment->id }}">Details</a>
        </li>
    @endif
    <li class="active">
        <strong>{{ $shipment->exists ? 'Edit' : 'Create' }}</strong>
    </li>
</ol>
@stop

@section('actions')
    @include('admin.shipments._form_actions')
@stop

@section('page_content')
<form id="shipment-form" action="/shipment/{{ $shipment->exists ? $shipment->id . '/update' : 'store' }}" method="post" class="form-horsizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-md-9">
                @include('admin.shipments._form_packages', ['packages' => $packages])
            </div>
            <div class="col-md-3">
                @include('admin.shipments._form_details')
            </div>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-content text-right">
                @include('admin.shipments._form_actions')
            </div>
        </div>
    </div>
</div>
<script src="/assets/admin/js/shipment-form.js"></script>
@stop
