@extends('layouts.admin.page')

@section('icon', 'cube')

@section('title')
    {{ $warehouse->exists ? 'Edit Warehouse # ' . $warehouse->id : 'Create Warehouse' }}
@stop

@section('subtitle')
<ol class="breadcrumb">
    <li>
        <a href="/warehouses">Warehouses</a>
    </li>
    @if ($warehouse->exists)
        <li>
            <a href="/warehouses/show/{{ $warehouse->id }}">Detail</a>
        </li>
    @endif
    <li class="active">
        <strong>{{ $warehouse->exists ? 'Edit' : 'Create' }}</strong>
    </li>
</ol>
@stop

@section('page_content')
<form action="/warehouses/{{ $warehouse->exists ? 'update/' . $warehouse->id : 'store' }}" method="post" class="form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div id="flashMessage"></div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <h3>Warehouse Info</h3>
                    <div class="clear hr-line-dashed"></div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Date</label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input required type="text" name="warehouse[date]" class="date form-control" value="{{ ($warehouse->exists) ? date('m/d/Y', strtotime($warehouse->arrived_at)) : date('m/d/Y') }}">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group bootstrap-timepicker">
                                <input required type="text" name="warehouse[time]" class="form-control" value="{{ ($warehouse->exists) ? date('g:i A', strtotime($warehouse->arrived_at)) : date('g:i A') }}">
                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Shipper</label>
                        <div class="col-sm-5">
                            <input type="hidden" id="shipperId" name="warehouse[shipper_account_id]" value="{{ $warehouse->shipper_account_id }}">
                            <input required type="text" id="shipper" name="warehouse[shipper]" class="form-control" value="{{ $warehouse->present()->shipper() }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Consignee</label>
                        <div class="col-sm-5">
                            <input type="hidden" id="consigneeId" name="warehouse[consignee_account_id]" value="{{ $warehouse->consignee_account_id }}">
                            <input required type="text" id="consignee" name="warehouse[consignee]" class="form-control" value="{{ $warehouse->present()->consignee() }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Delivered By</label>
                        <div class="col-sm-5">
                            <input required type="text" id="carrier" name="warehouse[carrier]" class="form-control" value="{{ $warehouse->present()->carrier() }}">
                            <input type="hidden" id="carrierId" name="warehouse[carrier_id]" value="{{ $warehouse->carrier_id }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Notes</label>
                        <div class="col-sm-5">
                            <textarea class="form-control" name="warehouse[notes]">{{ $warehouse->notes }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            @include('warehouses._metric_system_notice')

            <div class="ibox">
                <div class="ibox-content">
                    <h3>Pieces{{ $warehouse->exists ? ' (' . $warehouse->packages->count() . ')' : '' }}</h3>
                    <div class="clear hr-line-dashed"></div>
                    <button type="button" id="btnNewPackage" class="btn btn-success"><i class="fa fa-plus"></i> Add New</button>
                    <br><br>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    <span id="totalPackages" class="btn btn-primary m-r-sm">0</span>
                                    Pieces
                                </td>
                                <td>
                                    <span id="grossWeight" class="btn btn-danger m-r-sm">0</span>
                                    Gross Weight
                                </td>
                                <td>
                                    <span id="volumeWeight" class="btn btn-success m-r-sm">0</span>
                                    Volume Weight
                                </td>
                                <td>
                                    <span id="chargeWeight" class="btn btn-warning m-r-sm">0</span>
                                    Charge Weight
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    @include('warehouses.edit.packages')

                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="form-group">
        <div class="col-sm-4">
            <a class="btn btn-white" href="/warehouses{{ $warehouse->exists ? '/show/' . $warehouse->id : '' }}">Cancel</a>
            <button class="btn btn-primary" type="submit">Save changes</button>
        </div>
    </div>
</form>

<script src="/assets/admin/js/pages/warehouses/edit.js"></script>
@stop
