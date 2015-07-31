<div class="ibox">
    <div class="ibox-content">
        <h2>Pieces - In Shipment</h2>
        <div class="clear hr-line-dashed"></div>
        <table class="table table-stsriped">
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Tracking #</th>
                    <th>Value</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($assignedPackagesGrouped as $warehouseId => $packages)
                    <tr class="info">
                        <td colspan="9">
                            <i>Warehouse</i> {!! $packages[0]->present()->warehouseLink() !!}
                            <i>Client</i> {!! $packages[0]->warehouse->present()->clientLink() !!}
                        </td>
                    </tr>
                    @foreach ($packages as $package)
                        <tr>
                            <td><input type="checkbox" class="icheck-green" name="packages[{{ $package->id }}]"{{ $shipment->exists && $shipment->id == $package->shipment_id ? ' checked' : '' }}></td>
                            <td>{{ $package->id }}</td>
                            <td>{{ $package->type->name }}</td>
                            <td>{{ $package->tracking_number }}</td>
                            <td>{{ $package->present()->invoiceValue() }}</td>
                            <td>{{ $package->description }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" data-package-id="{{ $package->id }}" class="show-package-modal-btn btn-white btn btn-sm">View</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        @if ( ! count($assignedPackagesGrouped))
            <div class="alert alert-danger">
                <i class="fa fa-exclamation-triangle"></i>
                No packages available for shipment.
            </div>
        @endif
    </div>
</div>

