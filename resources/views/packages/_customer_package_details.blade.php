<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title">Package Details</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-xs-3"><strong>ID</strong></div>
        <div class="col-xs-9"><p>{{ $package->id }}</p></div>
    </div>
    <div class="row">
        <div class="col-xs-3"><strong>Status</strong></div>
        <div class="col-xs-9"><p>{!! $package->present()->statusText() !!}</p></div>
    </div>
    <div class="row">
        <div class="col-xs-3"><strong>Arrived</strong></div>
        <div class="col-xs-9"><p>{{ $package->present()->arrivalDate() }}</p></div>
    </div>
    <div class="row">
        <div class="col-xs-3"><strong>Shipper</strong></div>
        <div class="col-xs-9"><p>{{ $package->warehouse->shipper->name }}</p></div>
    </div>
    <div class="row">
        <div class="col-xs-3"><strong>Tracking #</strong></div>
        <div class="col-xs-9"><p>{{ $package->tracking_number }}</p></div>
    </div>

    <hr>

    <div class="row">
        <div class="col-xs-3"><strong>Type</strong></div>
        <div class="col-xs-9"><p>{{ $package->present()->type() }}</p></div>
    </div>
    <div class="row">
        <div class="col-xs-3"><strong>Weight</strong></div>
        <div class="col-xs-9"><p>{{ $package->weight }} Lbs</p></div>
    </div>
    <div class="row">
        <div class="col-xs-3"><strong>Dimensions</strong></div>
        <div class="col-xs-9"><p>{{ $package->present()->dimensions() }}</p></div>
    </div>

    <hr>

    <div class="row">
        <div class="col-xs-3"><strong>Value</strong></div>
        <div class="col-xs-9"><p>{{ $package->present()->value() }}</p></div>
    </div>

    <hr>

    <div class="row">
        <div class="col-xs-3"><strong>Description</strong></div>
        <div class="col-xs-9"><p>{{ $package->description }}</p></div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
</div>
