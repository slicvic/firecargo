@extends('layouts.members.master')

@section('content')

<div class="row">
    <h3>
        <i class="fa fa-cube"></i> Warehouse # {{ $warehouse->id }}
        <a href="/warehouses/edit/{{ $warehouse->id }}" class="btn-flat primary"><i class="fa fa-pencil"></i> Edit</a>
    </h3>
    <hr>
</div>

<table class="table table-striped">
    <tr>
        <th>Date</th>
        <td>{{ $warehouse->arrived_at }}</td>
    </tr>
    <tr>
        <th>Shipper</th>
        <td>{{ $warehouse->shipper ? $warehouse->shipper->fullname() : '' }}</td>
    </tr>
    <tr>
        <th>Consignee</th>
        <td>{{ $warehouse->consignee ? $warehouse->consignee->fullname() : '' }}</td>
    </tr>
    <tr>
        <th>Delivered By</th>
        <td>{{ $warehouse->deliveredBy ? $warehouse->deliveredBy->name : '' }}</td>
    </tr>
</table>

<h3>Packages</h3>
<table class="table table-striped">
    <tr>
        <th>ID</th>
        <th>Tracking #</th>
        <th>Status</th>
        <th>Type</th>
        <th>Length</th>
        <th>Width</th>
        <th>Height</th>
        <th>Weight</th>
        <th>Description</th>
        <th>Invoice #</th>
        <th>Invoice $</th>
    </tr>
    @foreach ($warehouse->packages() as $package)
        <tr>
            <td>{{ $package->id }}</td>
            <td>{{ $package->tracking_number }}</td>
            <td>{{ $package->status->name }}</td>
            <td>{{ $package->type->name }}</td>
            <td>{{ $package->length }}</td>
            <td>{{ $package->width }}</td>
            <td>{{ $package->height }}</td>
            <td>{{ $package->weight }}</td>
            <td>{{ $package->description }}</td>
            <td>{{ $package->invoice_number }}</td>
            <td>{{ $package->invoice_amount }}</td>
        </tr>
    @endforeach
</table>

@stop
