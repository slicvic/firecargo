@extends('layouts.admin.master')

@section('content')

<div class="row">
    <h3>
        <i class="fa fa-cube"></i> Warehouse # {{ $warehouse->id }}
        <a href="/warehouses/edit/{{ $warehouse->id }}" class="btn btn-primary"><i class="fa fa-pencil"></i> Edit</a>
        <a target="_blank" href="/warehouses/print-receipt/{{ $warehouse->id }}" class="btn btn-success"><i class="fa fa-print"></i> Print Receipt</a>
        <a target="_blank" href="/warehouses/print-label/{{ $warehouse->id }}" class="btn btn-info"><i class="fa fa-print"></i> Print Label</a>
    </h3>
    <hr>
</div>

<div class="panel panel-default">
    <div class="panel-heading">Warehouse Information</div>
    <div class="panel-body">
        <table class="table warehouse-info-table">
            <tr>
                <th class="col-sm-2">Date</th>
                <td>{{ $warehouse->prettyArrivedAt() }}</td>
            </tr>
            <tr>
                <th>Shipper</th>
                <td>{{ $warehouse->shipper ? $warehouse->shipper->business_name : '' }}</td>
            </tr>
            <tr>
                <th>Consignee</th>
                <td>{{ $warehouse->consignee ? $warehouse->consignee->getFullName() : '' }}</td>
            </tr>
            <tr>
                <th>Delivered By</th>
                <td>{{ $warehouse->courier ? $warehouse->courier->name : '' }}</td>
            </tr>
            <tr>
                <th>Pieces</th>
                <td>{{ $warehouse->countPackages() }}</td>
            </tr>
            <tr>
                <th>Gross Weight</th>
                <td>{{ $warehouse->calculateGrossWeight() }} lb(s)</td>
            </tr>
            <tr>
                <th>Volume Weight</th>
                <td>{{ $warehouse->calculateVolumeWeight() }} lb(s)</td>
            </tr>
            <tr>
                <th>Charge Weight</th>
                <td>{{ $warehouse->calculateChargeWeight() }} lb(s)</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{{ $warehouse->description }}</td>
            </tr>
        </table>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">Packages</div>
    <div class="panel-body">
        <div class="alert alert-warning">
            <i class="fa fa-exclamation-triangle"></i> Warehouse is setup in US SYSTEM - using inches and pounds
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>L x W x H</th>
                    <th>Weight</th>
                    <th>Description</th>
                    <th>Tracking #</th>
                    <th>Invoice #</th>
                    <th>Invoice $</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($warehouse->packages() as $package)
                    <tr>
                        <td>{{ $package->id }}</td>
                        <td>{{ ($type = $package->type) ? $type->name: '' }}</td>
                        <td>{{ ($status = $package->status) ? $status->name : '' }}</td>
                        <td>{{ $package->length . ' x ' . $package->width . ' x ' . $package->height }}</td>
                        <td>{{ $package->weight }} lb(s)</td>
                        <td>{{ $package->description }}</td>
                        <td>{{ $package->tracking_number }}</td>
                        <td>{{ $package->invoice_number }}</td>
                        <td>{{ $package->invoice_amount }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop
