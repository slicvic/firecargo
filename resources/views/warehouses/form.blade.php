@extends('layouts.members.form')

@section('icon', 'cube')
@section('title')
    {{ $warehouse->id ? 'Edit' : 'Create' }} Warehouse
@stop

@section('form')
<form data-parsley-validate action="/warehouses/{{ ($warehouse->id) ? 'update/' . $warehouse->id : 'store' }}" method="post" id="createWarehouseForm" class="form-horizontal">
    <div class="flashError"></div>
    <div class="panel panel-default">
        <div class="panel-heading">Warehouse Information</div>
        <div class="panel-body">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="warehouse[site_id]" value="{{ ($warehouse->id) ? $warehouse->site_id : Auth::user()->site_id }}">

            <div class="form-group">
                <label class="control-label col-sm-2">Date</label>
                <div class="col-sm-2">
                    <div class="input-group">
                        <input required type="text" name="warehouse[arrived_at][date]" class="form-control" value="{{ ($warehouse->arrived_at) ? date('m/d/Y', strtotime($warehouse->arrived_at)) : date('m/d/Y') }}">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="input-group bootstrap-timepicker">
                        <input required type="text" name="warehouse[arrived_at][time]" class="form-control" value="{{ ($warehouse->arrived_at) ? date('g:i A', strtotime($warehouse->arrived_at)) : date('g:i A') }}">
                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Shipper</label>
                <div class="col-sm-5">
                    <input required type="text" id="shipperName" name="shipper_name" class="form-control" value="{{ ($warehouse->shipper) ? $warehouse->shipper->fullname() : '' }}">
                    <input type="hidden" id="shipperId" name="warehouse[shipper_user_id]" value="{{ $warehouse->shipper_user_id }}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Consignee</label>
                <div class="col-sm-5">
                    <input required  type="text" id="consigneeName" name="consignee_name" class="form-control" value="{{ ($warehouse->consignee) ? $warehouse->consignee->fullname() : '' }}">
                    <input type="hidden" id="consigneeId" name="warehouse[consignee_user_id]" value="{{ $warehouse->consignee_user_id }}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Delivered By</label>
                <div class="col-sm-5">
                    <select required name="warehouse[delivered_by_courier_id]" class="form-control">
                        @foreach (\App\Models\Courier::allByCurrentSiteId() as $courier)
                            <option{{ ($warehouse->courier_id == $courier->id) ? ' selected' : '' }} value="{{ $courier->id }}">{{ $courier->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Packages</div>
        <div class="panel-body">
            <div class="alert alert-warning">
                <i class="fa fa-exclamation-triangle"></i> Warehouse is setup in US SYSTEM - using inches and pounds
            </div>
            <button type="button" id="newPkgBtn" class="btn btn-success"><i class="fa fa-plus"></i> New</button>
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
                        <td><span id="actualWeight">0</span></td>
                        <td><span id="volumeWeight">0</span></td>
                        <td><span id="chargeWeight">0</span></td>
                    </tr>
                </tbody>
            </table>

            {!! view('warehouses._form_packages', ['warehouse' => $warehouse]) !!}
        </div>
    </div>
    <button type="submit" class="btn btn-flat primary">Save Changes</button>
    <a href="/warehouses">Cancel</a>
</form>

<link rel="stylesheet" href="/assets/libs/jquery-ui/jquery-ui.min.css">
<script src="/assets/libs/jquery-ui/jquery-ui.min.js"></script>
<script>
$(function() {
    var Packages = {
        $trTemplate: null,

        init: function() {
            this.initEvents();
            this.updateTotals();
        },

        initEvents: function() {
            var self = this;
            self.$trTemplate = $('#packagesTable > tbody > tr:first-child').clone();
            $('#packagesTable').on('click', '.clonePkgBtn', self.clonePackage);
            $('#packagesTable').on('click', '.removePkgBtn', self.removePackage);
            $('#newPkgBtn').on('click', self.newPackage);
            $('#packagesTable').on('keyup', '.metric', self.updateTotals);
        },

        clonePackage: function() {
            var rowCount = Packages.countPackages();
            var $trClone = $(this).parent().parent().clone();
            var idx;

            $trClone.find('input.unique').val('');

            $trClone.find('input, select').each(function() {
                idx = -1 * rowCount;
                $(this).attr('name', 'package[' + idx + '][' + $(this).attr('data-name') + ']');
            });

            $('#packagesTable > tbody').append($trClone);
            $('#totalPieces').html(1 + rowCount);

            Packages.updateTotals();
        },

        newPackage: function() {
            var rowCount = Packages.countPackages();
            var $trNew = Packages.$trTemplate.clone();
            var idx;

            $trNew.find('input, select').each(function() {
                idx = -1 * rowCount;
                $(this).val('');
                $(this).attr('name', 'package[' + idx + '][' + $(this).attr('data-name') + ']');
            });

            $('#packagesTable > tbody').append($trNew);
            $('#totalPieces').html(1 + rowCount);

            Packages.updateTotals();
        },

        removePackage: function() {
            $(this).parent().parent().remove();
            Packages.updateTotals();
        },

        countPackages: function() {
            return $('#packagesTable > tbody > tr').length;
        },

        updateTotals: function() {
            var actualWeight = 0;
            var volumeWeight = 0;
            var volumeWeightDivisor = <?php echo \App\Models\Package::VOLUME_WEIGHT_DIVISOR; ?>;

            $('#packagesTable > tbody > tr').each(function() {
                var $tr = $(this);

                var length = parseInt($tr.find('input[data-name="length"]').val()) || 0;
                var width = parseInt($tr.find('input[data-name="width"]').val()) || 0;
                var height = parseInt($tr.find('input[data-name="height"]').val()) || 0;
                var weight = parseInt($tr.find('input[data-name="weight"]').val()) || 0;

                actualWeight += weight;
                volumeWeight += (length * width * height) / volumeWeightDivisor;
            });

            volumeWeight = Math.round(volumeWeight * 100) / 100;

            $('#totalPieces').html(Packages.countPackages());
            $('#actualWeight').html(actualWeight + ' lb(s)');
            $('#volumeWeight').html(volumeWeight + ' lb(s)');
            $('#chargeWeight').html((volumeWeight > actualWeight ? volumeWeight : actualWeight) + ' lb(s)');
        }
    };

    Packages.init();

    // Bind shipper autocomplete
    $('#shipperName').autocomplete({
        source: '/accounts/autocomplete',
        minLength: 2,
        select: function(event, ui) {
            $('#shipperName').val(ui.item.label);
            $('#shipperId').val(ui.item.id);
            return false;
        }
    }).autocomplete('instance')._renderItem = function(ul, item) {
        return $('<li>')
            .append('<a>' + item.id  + ' - ' + item.label + '</a>')
            .appendTo(ul);
    };

    // Bind consignee autocomplete
    $('#consigneeName').autocomplete({
        source: '/accounts/autocomplete',
        minLength: 2,
        select: function(event, ui) {
            $('#consigneeName').val(ui.item.label);
            $('#consigneeId').val(ui.item.id);
            return false;
        }
    }).autocomplete('instance')._renderItem = function(ul, item) {
        return $('<li>')
            .append('<a>' + item.id  + ' - ' + item.label + '</a>')
            .appendTo(ul);
    };
});
</script>
@stop
