<?php if ( ! count($packages)) { ?>
    <div class="alert alert-warning text-center"><i class="fa fa-exclamation-triangle"></i> No Pieces In Shipment</div>
<?php return; } ?>

<div class="table-responsive">
    <table class="table table-striped table-bordered datatable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Tracking #</th>
                <th>Value</th>
                <th>Description</th>
                <th>Warehouse</th>
                <th>Client</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($packages as $package)
                <tr>
                    <td>{{ $package->id }}</td>
                    <td>{{ $package->type->name }}</td>
                    <td>{{ $package->tracking_number }}</td>
                    <td>{{ $package->present()->invoiceValue() }}</td>
                    <td>{{ $package->description }}</td>
                    <td>{!! $package->present()->warehouseLink() !!}</td>
                    <td>{!! $package->present()->clientLink() !!}</td>
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
