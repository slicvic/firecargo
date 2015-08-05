<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title">Piece # {{ $package->id }}</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-xs-3"><strong>Tracking #</strong></div>
        <div class="col-xs-9"><p><a href="#" class="editable" data-name="tracking_number">{{ $package->tracking_number }}</a></p></div>
    </div>
    <div class="row">
        <div class="col-xs-3"><strong>Customer</strong></div>
        <div class="col-xs-9"><p>{!! $package->present()->customerLink() !!}</p></div>
    </div>
    <div class="row">
        <div class="col-xs-3"><strong>Warehouse #</strong></div>
        <div class="col-xs-9"><p>{!! $package->present()->warehouseLink() !!}</p></div>
    </div>
    <div class="row">
        <div class="col-xs-3"><strong>Shipment #</strong></div>
        <div class="col-xs-9"><p>{!! $package->present()->shipmentLink() !!}</p></div>
    </div>

    <hr>

    <div class="row">
        <div class="col-xs-3"><strong>Type</strong></div>
        <div class="col-xs-9"><p><a href="#" id="type" class="editable" data-type="select" data-value="{{ $package->type_id }}" data-source="/package-types/editable-options" data-name="type_id">{{ $package->present()->type() }}</a></p></div>
    </div>
    <div class="row">
        <div class="col-xs-3"><strong>Weight</strong></div>
        <div class="col-xs-9"><p><a href="#" class="editable" data-name="weight">{{ $package->weight }}</a> Lbs</p></div>
    </div>
    <div class="row">
        <div class="col-xs-3"><strong>LxWxH</strong></div>
        <div class="col-xs-9">
            <a href="#" class="editable" data-name="length">{{ $package->length }}</a> x
            <a href="#" class="editable" data-name="width">{{ $package->width }}</a> x
            <a href="#" class="editable" data-name="height">{{ $package->height }}</a>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-xs-3"><strong>Invoice #</strong></div>
        <div class="col-xs-9"><p><a href="#" class="editable" data-name="invoice_number">{{ $package->invoice_number }}</a></p></div>
    </div>
    <div class="row">
        <div class="col-xs-3"><strong>Invoice $</strong></div>
        <div class="col-xs-9"><p>$ <a href="#" class="editable" data-name="invoice_value">{{ $package->present()->value(FALSE) }}</a></p></div>
    </div>

    <hr>

    <div class="row">
        <div class="col-xs-3"><strong>Description</strong></div>
        <div class="col-xs-9"><p><a href="#" class="editable" data-name="description">{{ $package->description }}</a></p></div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
</div>

<script>
    $.fn.editable.defaults.mode = 'inline';

    $(document).ready(function() {
        $('.editable').editable({
            pk: '{{ $package->id }}',
            url: '/package/{{ $package->id}}/editable-field'
        });
    });
</script>
