<div class="ibox">
    <div class="ibox-content">
        <h2>Details</h2>
        <div class="clear hr-line-dashed"></div>

        <div class="form-group">
            <label class="control-label ccol-sm-2">Reference #</label>
            <div class="ccol-sm-4">
                <input required type="text" name="shipment[reference_number]" placeholder="" class="form-control" value="{{ $shipment->reference_number }}">
                <p class="help-block">e.g. Air Waybill, Bill of Lading or Container #</p>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label ccol-sm-2">Departure</label>
            <div class="ccol-sm-4">
                <div class="input-group">
                    <input required type="text" name="shipment[departure_date]" class="date form-control" value="{{ $shipment->present()->departedAt() }}">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label ccol-sm-2">Carrier</label>
            <div class="ccol-sm-4">
                <input required type="text" id="carrier" name="shipment[carrier]" placeholder="e.g. DHL" class="form-control" value="{{ $shipment->present()->carrier() }}">
                <input type="hidden" id="carrierId" name="shipment[carrier_id]" value="{{ $shipment->carrier_id }}">
            </div>
        </div>
    </div>
</div>
