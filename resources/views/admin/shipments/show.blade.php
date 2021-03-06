@extends('admin.layouts.page')

@section('title')
    Shipment # {{ $shipment->id }}
@stop

@section('subtitle')
<ol class="breadcrumb">
    <li>
        <a href="/shipments">Shipments</a>
    </li>
    <li class="active">
        <strong>Details</strong>
    </li>
</ol>
@stop

@section('actions')
    <a href="/shipment/{{ $shipment->id }}/edit" class="btn btn-primary"><i class="fa fa-pencil"></i> Edit Shipment</a>
@stop

@section('page_content')
<div class="row">
    <div class="col-md-9">
        <div class="ibox">
            <div class="ibox-content">
                <h2>Pieces ({{ $shipment->packages->count() }})</h2>
                @include('admin.packages._shipment_packages', ['packages' => $shipment->packages])
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="ibox">
            <div class="ibox-content">
                <h2>Details</h2>
                <table class="table table-responsive">
                    <tr>
                        <th>Ref #</th>
                        <td><span class="label label-warning">{{ $shipment->reference_number }}</span></td>
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
                        <td><span class="label label-primary">{{ $shipment->present()->value() }}</span></td>
                    </tr>
                    <tr>
                        <th>Created</th>
                        <td>{{ $shipment->present()->createdAt() }}</td>
                    </tr>
                    <tr>
                        <th>Modified</th>
                        <td>{{ $shipment->present()->updatedAt() }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
$(function() {
    app.closeNavbar();
});
</script>
@stop
