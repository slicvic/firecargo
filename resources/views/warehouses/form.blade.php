@extends('layouts.admin.model.form')

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

@section('form')
    <form data-parsley-validate action="/warehouses/{{ $warehouse->exists ? 'update/' . $warehouse->id : 'store' }}" method="post" class="form-horizontal">
        <div id="flashMessage"></div>
        <div class="ibox">
            <div class="ibox-title"><h5>Warehouse Info</h5></div>
            <div class="ibox-content">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label class="control-label col-sm-2">Date</label>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input required type="text" name="warehouse[arrived_at][date]" class="date form-control" value="{{ ($warehouse->exists) ? date('m/d/Y', strtotime($warehouse->arrived_at)) : date('m/d/Y') }}">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group bootstrap-timepicker">
                            <input required type="text" name="warehouse[arrived_at][time]" class="form-control" value="{{ ($warehouse->exists) ? date('g:i A', strtotime($warehouse->arrived_at)) : date('g:i A') }}">
                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Shipper</label>
                    <div class="col-sm-5">
                        <input type="hidden" id="shipperId" name="warehouse[shipper_user_id]" value="{{ $warehouse->shipper_user_id }}">
                        <div class="input-group">
                            <input required type="text" id="shipper" name="shipper" class="form-control" value="{{ $warehouse->present()->shipper(TRUE) }}">
                            <span class="input-group-addon"><a target="_blank" href="/accounts/create"><i class="fa fa-plus"></i></a></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Consignee</label>
                    <div class="col-sm-5">
                        <input type="hidden" id="consigneeId" name="warehouse[consignee_user_id]" value="{{ $warehouse->consignee_user_id }}">
                        <div class="input-group">
                            <input required  type="text" id="consignee" name="consignee" class="form-control" value="{{ $warehouse->present()->consignee(TRUE) }}">
                            <span class="input-group-addon"><a target="_blank" href="/accounts/create"><i class="fa fa-plus"></i></a></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Delivered By</label>
                    <div class="col-sm-5">
                        <input required  type="text" id="carrier" name="warehouse[carrier_name]" class="form-control" value="{{ $warehouse->present()->carrier(TRUE) }}">
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

        <div class="ibox">
            <div class="ibox-title"><h5>Pieces</h5></div>
            <div class="ibox-content">
                @include('warehouses._alert_us_metric_system')
                <button type="button" id="btnNewPackage" class="btn btn-success"><i class="fa fa-plus"></i> Add New</button>
                <br><br>
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th>Pieces</th>
                            <th>Gross Weight</th>
                            <th>Volume Weight</th>
                            <th>Charge Weight</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span id="totalPackages">0</span></td>
                            <td><span id="grossWeight">0</span></td>
                            <td><span id="volumeWeight">0</span></td>
                            <td><span id="chargeWeight">0</span></td>
                        </tr>
                    </tbody>
                </table>

                {!! view('warehouses.form.packages', ['warehouse' => $warehouse]) !!}
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-4">
                <a class="btn btn-white" href="/warehouses/show/{{ $warehouse->id }}">Cancel</a>
                <button class="btn btn-primary" type="submit">Save changes</button>
            </div>
        </div>
    </form>

    <link rel="stylesheet" href="/assets/vendor/jquery-ui/jquery-ui.min.css">
    <script src="/assets/vendor/jquery-ui/jquery-ui.min.js"></script>
    <script src="/assets/admin/js/warehouses/form.js"></script>
@stop
