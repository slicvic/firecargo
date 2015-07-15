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
    @include('warehouses._metric_system_notice')
    <div class="row">
        <div class="col-md-9">
            <div class="ibox">
                <div class="ibox-content">
                    <h2>Pieces ({{ $warehouse->packages->count() }})</h2>
                    {!! @view('packages._list_warehouse', ['packages' => $packages]) !!}
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h2>Summary</h2>
                    <table class="table warehouse-info-table table-responsive">
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
                            <td><span class="label label-danger">{{ count($packages) }}</span></td>
                        </tr>
                        <tr>
                            <th>Total Value</th>
                            <td><span class="label label-primary">{{ $warehouse->present()->totalValue() }}</span></td>
                        </tr>
                        <tr>
                            <th>Gross Weight</th>
                            <td><span class="label label-success">{{ $warehouse->present()->grossWeight() }}</span></td>
                        </tr>
                        <tr>
                            <th>Volume Weight</th>
                            <td><span class="label label-success">{{ $warehouse->present()->volumeWeight() }}</span></td>
                        </tr>
                        <tr>
                            <th>Charge Weight</th>
                            <td><span class="label label-success">{{ $warehouse->present()->chargeWeight() }}</span></td>
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
