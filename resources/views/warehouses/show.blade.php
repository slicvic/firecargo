<?php $packages = $warehouse->packages; ?>

@extends('layouts.admin.master')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Warehouse # {{ $warehouse->id }}</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/warehouses">Warehouses</a>
            </li>
            <li class="active">
                <strong>Detail</strong>
            </li>
        </ol>
    </div>
    <div class="col-sm-8">
        <div class="title-action">
            <a href="/warehouses/edit/{{ $warehouse->id }}" class="btn btn-primary"><i class="fa fa-pencil"></i> Edit</a>
            <a target="_blank" href="/warehouses/print-receipt/{{ $warehouse->id }}" class="btn btn-success"><i class="fa fa-print"></i> Print Receipt</a>
            <a target="_blank" href="/warehouses/print-label/{{ $warehouse->id }}" class="btn btn-success"><i class="fa fa-print"></i> Print Label</a>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-md-9">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Pieces</h5>
                </div>
                <div class="ibox-content">
                    @include('warehouses._alert_us_metric_system')
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
                            @foreach ($packages as $package)
                                <tr>
                                    <td>{{ $package->id }}</td>
                                    <td>{{ $package->present()->type() }}</td>
                                    <td>{{ $package->present()->status() }}</td>
                                    <td>{{ $package->present()->dimensions() }}</td>
                                    <td>{{ $package->present()->weight() }}</td>
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
        </div>
        <div class="col-md-3">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Summary</h5>
                </div>
                <div class="ibox-content">
                    <table class="table warehouse-info-table table-responsive">
                        <tr>
                            <th class="col-sm-2">ID</th>
                            <td>{{ $warehouse->id }}</td>
                        </tr>
                        <tr>
                            <th>Arrived</th>
                            <td>{{ $warehouse->present()->arrivedAt() }}</td>
                        </tr>
                        <tr>
                            <th>Shipper</th>
                            <td>{!! $warehouse->present()->shipperLink() !!}</td>
                        </tr>
                        <tr>
                            <th>Consignee</th>
                            <td>{!! $warehouse->present()->consigneeLink() !!}</td>
                        </tr>
                        <tr>
                            <th>Delivered By</th>
                            <td>{{ $warehouse->present()->carrier() }}</td>
                        </tr>
                        <tr>
                            <th>Pieces</th>
                            <td>{{ count($packages) }}</td>
                        </tr>
                        <tr>
                            <th>Gross Weight</th>
                            <td>{{ $warehouse->present()->grossWeight() }}</td>
                        </tr>
                        <tr>
                            <th>Volume Weight</th>
                            <td>{{ $warehouse->present()->volumeWeight() }}</td>
                        </tr>
                        <tr>
                            <th>Charge Weight</th>
                            <td>{{ $warehouse->present()->chargeWeight() }}</td>
                        </tr>
                        <tr>
                            <th>Notes</th>
                            <td>{{ $warehouse->notes }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
