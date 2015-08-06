<a class="btn btn-white" href="{{ $shipment->exists ? '/shipment/' . $shipment->id : '/shipments' }}">Cancel</a>
<button class="btn btn-primary save-shipment-btn" data-loading-text="Saving..." type="submit">Save Shipment</button>
