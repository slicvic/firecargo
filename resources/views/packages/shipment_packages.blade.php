<div class="table-responsive">
    <table class="table table-striped table-bordered datatable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Warehouse</th>
                <th>Client</th>
                <th>Type</th>
                <th>Tracking #</th>
                <th>Value</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($packages as $package)
                <tr>
                    <td>{{ $package->id }}</td>
                    <td>{!! $package->present()->warehouseLink() !!}</td>
                    <td>{!! $package->present()->clientLink() !!}</td>
                    <td>{{ $package->type->name }}</td>
                    <td>{{ $package->tracking_number }}</td>
                    <td>{{ $package->present()->invoiceAmount() }}</td>
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
