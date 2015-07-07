@extends('layouts.admin.model.form')

@section('icon', 'cube')

@section('title')
    {{ $warehouse->id ? 'Edit Warehouse # ' . $warehouse->id : 'Create Warehouse' }}
@stop

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="/warehouses">Warehouses</a>
        </li>
        @if ($warehouse->id)
            <li>
                <a href="/warehouses/show/{{ $warehouse->id }}">{{ $warehouse->id }}</a>
            </li>
        @endif
        <li class="active">
            <strong>{{ $warehouse->id ? 'Edit' : 'Create' }}</strong>
        </li>
    </ol>
@stop

@section('form')
    <form data-parsley-validate action="/warehouses/{{ ($warehouse->id) ? 'update/' . $warehouse->id : 'store' }}" method="post" class="form-horizontal">
        <div id="flashError"></div>
        <div class="ibox">
            <div class="ibox-title"><h5>Warehouse Details</h5></div>
            <div class="ibox-content">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="warehouse[company_id]" value="{{ ($warehouse->id) ? $warehouse->company_id : Auth::user()->company_id }}">

                <div class="form-group">
                    <label class="control-label col-sm-2">Date</label>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <input required type="text" name="warehouse[arrived_at][date]" class="form-control" value="{{ ($warehouse->id) ? date('m/d/Y', strtotime($warehouse->arrived_at)) : date('m/d/Y') }}">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group bootstrap-timepicker">
                            <input required type="text" name="warehouse[arrived_at][time]" class="form-control" value="{{ ($warehouse->id) ? date('g:i A', strtotime($warehouse->arrived_at)) : date('g:i A') }}">
                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Shipper</label>
                    <div class="col-sm-5">
                        <input required type="text" id="shipperName" name="shipper_name" class="form-control" value="{{ $warehouse->present()->shipperName() }}">
                        <input type="hidden" id="shipperId" name="warehouse[shipper_user_id]" value="{{ $warehouse->shipper_user_id }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Consignee</label>
                    <div class="col-sm-5">
                        <input required  type="text" id="consigneeName" name="consignee_name" class="form-control" value="{{ $warehouse->present()->consigneeName() }}">
                        <input type="hidden" id="consigneeId" name="warehouse[consignee_user_id]" value="{{ $warehouse->consignee_user_id }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Delivered By</label>
                    <div class="col-sm-5">
                        <select name="warehouse[courier_id]" class="form-control" required>
                            <option value=""></option>
                            @foreach (\App\Models\Courier::allByCurrentCompany() as $courier)
                                <option{{ ($warehouse->courier_id == $courier->id) ? ' selected' : '' }} value="{{ $courier->id }}">{{ $courier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <?php /*
                <div class="form-group">
                    <label class="control-label col-sm-2">Container</label>
                    <div class="col-sm-5">
                        <select name="warehouse[container_id]" class="form-control">
                            <option value=""></option>
                            @foreach (\App\Models\Container::allByCurrentCompany() as $container)
                                <option{{ ($warehouse->container_id == $container->id) ? ' selected' : '' }} value="{{ $container->id }}">{{ $container->tracking_number }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>*/?>
                <div class="form-group">
                    <label class="control-label col-sm-2">Notes</label>
                    <div class="col-sm-5">
                        <textarea class="form-control" name="warehouse[notes]">{{ $warehouse->notes }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="ibox">
            <div class="ibox-title"><h5>Packages</h5></div>
            <div class="ibox-content">
                <div class="alert alert-warning">
                    <i class="fa fa-exclamation-triangle"></i> Warehouse is setup in US SYSTEM - using inches and pounds.
                </div>
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
                            <td><span id="totalPieces">0</span></td>
                            <td><span id="grossWeight">0</span></td>
                            <td><span id="volumeWeight">0</span></td>
                            <td><span id="chargeWeight">0</span></td>
                        </tr>
                    </tbody>
                </table>

                {!! view('warehouses.form.packages', ['warehouse' => $warehouse]) !!}
            </div>
        </div>

        <a class="btn btn-white" href="/warehouses/show/{{ $warehouse->id }}">Cancel</a>
        <button class="btn btn-primary" type="submit">Save changes</button>
    </form>

    <link rel="stylesheet" href="/assets/vendor/jquery-ui/jquery-ui.min.css">
    <script src="/assets/vendor/jquery-ui/jquery-ui.min.js"></script>
    <script src="/assets/admin/js/warehouses/create-edit-page.js"></script>
@stop
