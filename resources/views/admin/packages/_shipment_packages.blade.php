<?php if ( ! count($packages)) { ?>
    <div class="alert alert-warning text-center"><i class="fa fa-exclamation-triangle"></i> No pieces in shipment.</div>
<?php return; } ?>

<div class="table-responsive">
    <table class="table table-striped table-bordered datatable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tracking #</th>
                <th>Type</th>
                <th>Weight</th>
                <th>Value</th>
                <th>Description</th>
                <th>Customer</th>
                <th>Warehouse</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($packages as $package)
                <tr>
                    <td>{{ $package->id }}</td>
                    <td>{{ $package->tracking_number }}</td>
                    <td>{{ $package->type->name }}</td>
                    <td>{{ $package->present()->weight() }}</td>
                    <td>{{ $package->present()->value() }}</td>
                    <td>{{ $package->description }}</td>
                    <td>{!! $package->present()->customerLink() !!}</td>
                    <td>{!! $package->present()->warehouseLink() !!}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" data-url="/package/{{ $package->id }}/details" class="show-package-modal-btn btn-white btn btn-sm">View</button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
