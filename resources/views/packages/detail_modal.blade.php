<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title">Piece # {{ $package->id }}</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-xs-3"><strong>Warehouse #</strong></div>
        <div class="col-xs-9"><p>{!! $package->present()->warehouseLink() !!}</p></div>
    </div>
    <div class="row">
        <div class="col-xs-3"><strong>Client</strong></div>
        <div class="col-xs-9"><p>{!! $package->present()->clientLink() !!}</p></div>
    </div>
    <div class="row">
        <div class="col-xs-3"><strong>Shipment #</strong></div>
        <div class="col-xs-9"><p>{!! $package->present()->shipmentLink() !!}</p></div>
    </div>

    <br>

    <div class="row">
        <div class="col-xs-3"><strong>Type</strong></div>
        <div class="col-xs-9"><p>{{ $package->present()->type() }}</p></div>
    </div>
    <div class="row">
        <div class="col-xs-3"><strong>Weight</strong></div>
        <div class="col-xs-9"><p>{{ $package->present()->weight() }}</p></div>
    </div>
    <div class="row">
        <div class="col-xs-3"><strong>LxWxH</strong></div>
        <div class="col-xs-9"><p>{{ $package->present()->dimensions() }}</p></div>
    </div>

    <br>

    <div class="row">
        <div class="col-xs-3"><strong>Tracking #</strong></div>
        <div class="col-xs-9"><p>{{ $package->tracking_number }}</p></div>
    </div>

    <br>

    <div class="row">
        <div class="col-xs-3"><strong>Invoice #</strong></div>
        <div class="col-xs-9"><p>{{ $package->invoice_number }}</p></div>
    </div>
    <div class="row">
        <div class="col-xs-3"><strong>Invoice $</strong></div>
        <div class="col-xs-9"><p>{{ $package->present()->invoiceAmount() }}</p></div>
    </div>

    <br>

    <div class="row">
        <div class="col-xs-3"><strong>Description</strong></div>
        <div class="col-xs-9"><p>{{ $package->description }}</p></div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
</div>
