<?php if ( ! count($packages)) { ?>
    <div class="alert alert-warning text-center"><i class="fa fa-exclamation-triangle"></i> No pieces in warehouse.</div>
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
                <th>Shipment</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($packages as $package)
                <tr class="{{ $package->present()->statusCssClass() }}">
                    <td>{{ $package->id }}</td>
                    <td>{{ $package->tracking_number }}</td>
                    <td>{{ $package->present()->type() }}</td>
                    <td>{{ $package->present()->weight() }}</td>
                    <td>{{ $package->present()->invoiceValue() }}</td>
                    <td>{{ $package->description }}</td>
                    <td>{!! $package->present()->shipmentLink() !!}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" data-package-id="{{ $package->id }}" data-loading-text="Loading..." class="show-package-modal-btn btn-white btn btn-sm">View</button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
