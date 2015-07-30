<div class="ibox">
    <div class="ibox-content">
        <h2>Pieces</h2>
        <div class="clear hr-line-dashed"></div>
        <table class="table table-stsriped">
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
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
                @foreach ($groupedPackages as $warehouseId => $packages)
                    <tr class="info">
                        <td colspan="9">
                            <i>Warehouse</i> {!! $packages[0]->present()->warehouseLink() !!}
                            <i>Client</i> {!! $packages[0]->warehouse->present()->clientLink() !!}
                        </td>
                    </tr>
                    @foreach ($packages as $package)
                        <tr>
                            <td><input type="checkbox" class="icheck" name="packages[{{ $package->id }}]"{{ $shipment->exists && $shipment->id == $package->shipment_id ? ' checked' : '' }}></td>
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
        @if ( ! count($groupedPackages))
            <div class="alert alert-danger">
                <i class="fa fa-exclamation-triangle"></i>
                No packages available for shipment.
            </div>
        @endif
    </div>
</div>
