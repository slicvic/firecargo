@extends('layouts.admin.master')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Shipment # {{ $shipment->id }}</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/shipments">Shipments</a>
            </li>
            <li class="active">
                <strong>Detail</strong>
            </li>
        </ol>
    </div>
    <div class="col-sm-8">
        <div class="title-action">
            <a href="/shipments/edit/{{ $shipment->id }}" class="btn btn-primary"><i class="fa fa-pencil"></i> Edit</a>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-md-9">
            <div class="ibox">
                <div class="ibox-content">
                    <h2>Pieces ({{ $shipment->packages->count() }})</h2>
                    {!! view('packages._list_shipment', ['packages' => $shipment->packages]) !!}
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="ibox">
                <div class="ibox-content">
                    <h2>Summary</h2>
                    <table class="table table-responsive">
                        <tr>
                            <th>Ref #</th>
                            <td><span class="label label-danger ">{{ $shipment->reference_number }}</span></td>
                        </tr>
                        <tr>
                            <th>Departed</th>
                            <td>{{ $shipment->present()->departedAt() }}</td>
                        </tr>
                        <tr>
                            <th>Carrier</th>
                            <td>{{ $shipment->present()->carrier() }}</td>
                        </tr>
                        <tr>
                            <th>Total Value</th>
                            <td><span class="label label-primary">{{ $shipment->present()->totalValue() }}</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
