<div class="ibox">
    <div class="ibox-content">
        <h2>Pieces </h2>
        <h4>Select pieces to add to this shipment.</h4>
        <div class="clear hr-line-dashed"></div>
        <div class="table-responsive">
            <table id="packages-table" class="table table-stsriped">
                <thead>
                    <tr>
                        <th></th>
                        <th data-filter="true">ID</th>
                        <th></th>
                        <th data-filter="true">Type</th>
                        <th data-filter="true">Tracking #</th>
                        <th data-filter="true">Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($packages as $package)
                        <tr>
                            <td><input type="checkbox" class="icheck" name="pieces[{{ $package->id }}]"{{ $shipment->exists && $shipment->id == $package->shipment_id ? ' checked' : '' }}></td>
                            <td>{{ $package->id }}</td>
                            <td><i>Warehouse:</i> {!! $package->present()->warehouseLink() !!} <i>Client:</i> {!! $package->present()->clientLink() !!}</td>
                            <td>{{ $package->type->name }}</td>
                            <td>{{ $package->tracking_number }}</td>
                            <td>{{ $package->description }}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" data-package-id="{{ $package->id }}" class="show-package-modal-btn btn-white btn btn-sm">View</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ( ! count($packages))
            <div class="alert alert-danger">
                <i class="fa fa-exclamation-triangle"></i>
                There are no pieces available for shipment at this moment.
            </div>
        @endif
    </div>
</div>
