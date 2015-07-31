@extends('layouts.admin.master')

@section('content')
<form id="shipment-edit-form" action="/shipments/{{ $shipment->exists ? 'update/' . $shipment->id : 'store' }}" method="post" class="form-horsizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>{{ $shipment->exists ? 'Edit Shipment # ' . $shipment->id : 'Create Shipment' }}</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="/shipments">Shipments</a>
                </li>
                @if ($shipment->exists)
                    <li>
                        <a href="/shipments/show/{{ $shipment->id }}">Detail</a>
                    </li>
                @endif
                <li class="active">
                    <strong>{{ $shipment->exists ? 'Edit' : 'Create' }}</strong>
                </li>
            </ol>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                <a class="btn btn-white" href="/shipments{{ $shipment->exists ? '/show/' . $shipment->id : '' }}">Cancel</a>
                <button class="btn btn-primary" data-loading-text="Saving..." type="submit">Save Shipment</button>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        {!! Flash::getHtml() !!}
        <div id="flash-message"></div>
        <div class="row">
            <div class="col-md-9">
                @include('shipments._edit_packages', ['packages' => $packages])
            </div>
            <div class="col-md-3">
                @include('shipments._edit_details')
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-content text-right">
                        <a class="btn btn-white" href="/shipments{{ $shipment->exists ? '/show/' . $shipment->id : '' }}">Cancel</a>
                        <button class="btn btn-primary" data-loading-text="Saving..." type="submit">Save Shipment</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script src="/assets/admin/js/shipment-edit.js"></script>
@stop
