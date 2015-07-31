@extends('layouts.admin.page')

@section('title')
    Warehouse # {{ $warehouse->id }}
@stop

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="/warehouses">Warehouses</a>
        </li>
        <li class="active">
            <strong>Detail</strong>
        </li>
    </ol>
@stop

@section('actions')
    <a href="/warehouses/edit/{{ $warehouse->id }}" class="btn btn-primary"><i class="fa fa-pencil"></i> Edit Warehouse</a>
    <a target="_blank" href="/warehouses/print-receipt/{{ $warehouse->id }}" class="btn btn-success"><i class="fa fa-print"></i> Print Receipt</a>
    <a target="_blank" href="/warehouses/print-label/{{ $warehouse->id }}" class="btn btn-success"><i class="fa fa-print"></i> Print Label</a>
@stop

@section('page_content')
    @include('warehouses._metric_system_alert')
    <div class="row">
        <div class="col-md-9">
            <div class="ibox">
                <div class="ibox-content">
                    <h2>Pieces ({{ $warehouse->packages->count() }})</h2>
                    @include('packages.warehouse_packages', ['packages' => $warehouse->packages])
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h2>Details</h2>
                    <table class="table warehouse-info-table table-responsive">
                        <tr>
                            <th>Shipper</th>
                            <td>{!! $warehouse->present()->shipperLink() !!}</td>
                        </tr>
                        <tr>
                            <th>Client</th>
                            <td>{!! $warehouse->present()->clientLink() !!}</td>
                        </tr>
                        <tr>
                            <th>Delivered By</th>
                            <td>{{ $warehouse->present()->carrier() }}</td>
                        </tr>
                        <tr>
                            <th>Pieces</th>
                            <td><span class="label label-warning">{{ $warehouse->packages->count() }}</span></td>
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
                        <tr>
                            <th>Created</th>
                            <td>{{ $warehouse->present()->createdAt() }}</td>
                        </tr>
                        <tr>
                            <th>Updated</th>
                            <td>{{ $warehouse->present()->updatedAt() }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
