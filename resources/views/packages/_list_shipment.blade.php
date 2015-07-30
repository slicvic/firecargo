<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Warehouse</th>
            <th>Type</th>
            <th>L x W x H</th>
            <th>Weight</th>
            <th>Tracking #</th>
            <th>Inv #</th>
            <th>Inv $</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($packages as $package)
            <tr>
                <td>{{ $package->id }}</td>
                <td>{!! $package->present()->warehouseLink() !!}</td>
                <td>{{ $package->type->name }}</td>
                <td>{{ $package->present()->dimensions() }}</td>
                <td>{{ $package->present()->weight() }}</td>
                <td>{{ $package->tracking_number }}</td>
                <td>{{ $package->invoice_number }}</td>
                <td>{{ $package->present()->invoiceAmount() }}</td>
                <td>
                    <div class="btn-group">
                        <button type="button" data-package-id="{{ $package->id }}" class="show-package-modal-btn btn-white btn btn-sm">View</button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
