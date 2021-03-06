<div class="ibox">
    <div class="ibox-content">
        <h2>Details</h2>
        <div class="clear hr-line-dashed"></div>
        <div class="form-group">
            <label class="control-label ccol-sm-2">Shipper *</label>
            <div class="ccol-sm-5">
                <input type="hidden" id="shipper-id" name="warehouse[shipper_account_id]" value="{{ $warehouse->shipper_account_id }}">
                <input required type="text" id="shipper-name" name="warehouse[shipper_name]" placeholder="e.g. Amazon" class="form-control" value="{{ $warehouse->present()->shipper() }}">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label ccol-sm-2">Customer *</label>
            <div class="ccol-sm-5">
                <input type="hidden" id="customer-id" name="warehouse[customer_account_id]" value="{{ $warehouse->customer_account_id }}">
                <input required type="text" id="customer-name" name="warehouse[customer_name]" placeholder="e.g. Neymar Jr" class="form-control" value="{{ $warehouse->present()->customer() }}">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label ccol-sm-2">Carrier *</label>
            <div class="ccol-sm-5">
                <input required type="text" id="carrier-name" name="warehouse[carrier_name]" placeholder="e.g. UPS" class="form-control" value="{{ $warehouse->present()->carrier() }}">
                <input type="hidden" id="carrier-id" name="warehouse[carrier_id]" value="{{ $warehouse->carrier_id }}">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label ccol-sm-2">Notes</label>
            <div class="ccol-sm-5">
                <textarea class="form-control" name="warehouse[notes]">{{ $warehouse->notes }}</textarea>
            </div>
        </div>
    </div>
</div>
