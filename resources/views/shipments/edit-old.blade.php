@extends('layouts.admin.model.form')

@section('icon', 'truck')

@section('title')
    {{ $shipment->exists ? 'Edit Shipment # ' . $shipment->id  : 'Create Shipment' }}
@stop

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="/shipments">Shipments</a>
        </li>
        @if ($shipment->exists)
            <li>
                <a href="/shipments/show/{{ $shipment->id }}">Detail</a>
            </li>
        @endif
        <li class="active">
            <strong>{{ $shipment->exists ? 'Edit' : 'Create' }}</strong>
        </li>
    </ol>
@stop

@section('form')
    <form data-parsley-validate action="/shipments/{{ $shipment->exists ? 'update/' . $shipment->id : 'store' }}" method="post" class="form-horizontal">
        <div id="flashMessage"></div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <h3>Shipment Details</h3>
                        <div class="clear hr-line-dashed"></div>

                        <div class="form-group">
                            <label class="control-label col-sm-2">Reference #</label>
                            <div class="col-sm-4">
                                <input required type="text" name="shipment[reference_number]" placeholder="" class="form-control" value="{{ $shipment->reference_number }}">
                                <p class="help-block">e.g. Air Waybill, Bill of Lading or Container #</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Departure</label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input required type="text" name="shipment[departure_date]" class="date form-control" value="{{ $shipment->present()->departedAt() }}">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">Carrier</label>
                            <div class="col-sm-4">
                                <input type="text" id="carrier" name="shipment[carrier_name]" placeholder="" class="form-control" value="{{ $shipment->present()->carrier(TRUE) }}">
                                <input type="hidden" id="carrierId" name="shipment[carrier_id]" value="{{ $shipment->carrier_id }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox">
                    <div class="ibox-content">
                        <h3>Pieces{{ $shipment->exists ? ' (' . $shipment->packages->count() . ')' : '' }}</h3>
                        <div class="clear hr-line-dashed"></div>
                        <table class="table table-stsriped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>#</th>
                                    <th>Type</th>
                                    <th>L x W x H</th>
                                    <th>Weight</th>
                                    <th>Tracking #</th>
                                    <th>Invoice #</th>
                                    <th>Invoice $</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($nestablePackages as $warehouseId => $packages)
                                    <tr class="warning">
                                        <td colspan="9">
                                            <i>Warehouse</i> {!! $packages[0]->present()->warehouseLink() !!}
                                            <i>Consignee</i> {!! $packages[0]->warehouse->present()->consigneeLink() !!}
                                        </td>
                                    </tr>
                                    @foreach ($packages as $package)
                                        <tr>
                                            <td><input type="checkbox" name="packages[{{ $package->id }}]"{{ $shipment->exists && $shipment->id == $package->shipment_id ? ' checked' : '' }}></td>
                                            <td>{{ $package->id }}</td>
                                            <td>{{ $package->type->name }}</td>
                                            <td>{{ $package->present()->dimensions() }}</td>
                                            <td>{{ $package->present()->weight() }}</td>
                                            <td>{{ $package->tracking_number }}</td>
                                            <td>{{ $package->invoice_number }}</td>
                                            <td>{{ $package->present()->invoiceAmount() }}</td>
                                            <td>{{ $package->description }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                        @if ( ! count($nestablePackages))
                            <div class="alert alert-danger">
                                <h4><i class="fa fa-exclamation-triangle"></i>
                                No packages available for shipment.</h4>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <br>

        <div class="form-group">
            <div class="col-sm-4">
                <a class="btn btn-white" href="/shipments{{ $shipment->exists ? '/show/' . $shipment->id : '' }}">Cancel</a>
                <button class="btn btn-primary" type="submit">Save changes</button>
            </div>
        </div>
    </form>

    <link rel="stylesheet" href="/assets/vendor/jquery-ui/jquery-ui.min.css">
    <script src="/assets/vendor/jquery-ui/jquery-ui.min.js"></script>

    <script>
    $(function() {
        // Bind nestable
        // $('#shipmentNestableList').nestable({});
        // $('#shipmentNestableList').nestable('expandAll');

        // Bind carrier autocomplete
        $('#carrier').keyup(function() {
            $('#carrierId').val('');
        });

        $('#carrier').autocomplete({
            source: '/carriers/ajax-autocomplete',
            minLength: 2,
            select: function(event, ui) {
                $('#carrierId').val(ui.item.id);
            }
        });

        // Bind form submit
        $('form').on('submit', function() {
            event.preventDefault();

            var $form = $(this),
                $flash = $('#flashMessage'),
                $submit = $(this).find('button');

            $submit.attr('disabled', true);
            $flash.html('');

            $.post($form.attr('action'), $form.serialize(), 'json')
                .done(function(data) {
                    window.location = data.redirect_url;
                })
                .fail(function(xhr) {
                    var data = JSON.parse(xhr.responseText);
                    $flash.html(data.error);
                    $('html, body').scrollTop(0);
                    $submit.attr('disabled', false);
                });
        });
     });
    </script>
@stop
