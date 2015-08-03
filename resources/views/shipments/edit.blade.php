@extends('layouts.admin.master')

@section('content')
<form id="shipment-edit-form" action="/shipment/{{ $shipment->exists ? $shipment->id . '/update' : 'store' }}" method="post" class="form-horsizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>{{ $shipment->exists ? 'Edit Shipment # ' . $shipment->id : 'Create New Shipment' }}</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="/shipments">Shipments</a>
                </li>
                @if ($shipment->exists)
                    <li>
                        <a href="/shipment/{{ $shipment->id }}/show">Detail</a>
                    </li>
                @endif
                <li class="active">
                    <strong>{{ $shipment->exists ? 'Edit' : 'Create' }}</strong>
                </li>
            </ol>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                <a class="btn btn-white" href="{{ $shipment->exists ? '/shipment/' . $shipment->id . '/show' : '/shipments' }}">Cancel</a>
                <button class="btn btn-primary" data-loading-text="Saving..." type="submit">Save Shipment</button>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
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
                        <a class="btn btn-white" href="{{ $shipment->exists ? '/shipment/' . $shipment->id . '/show' : '/shipments' }}">Cancel</a>
                        <button class="btn btn-primary" data-loading-text="Saving..." type="submit">Save Shipment</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script src="/assets/admin/js/shipment-edit.js"></script>
@stop
