<table class="table table-striped text-left">
    <thead>
        <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Status</th>
            <th>L x W x H</th>
            <th>Weight</th>
            <th>Tracking #</th>
            <th>Invoice #</th>
            <th>Invoice $</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($packages as $package)
            <tr>
                <td>{{ $package->id }}</td>
                <td>{{ ($package->type_id) ? $package->type->name: '' }}</td>
                <td>{{ ($package->status_id) ? $package->status->name : '' }}</td>
                <td>{{ $package->length . ' x ' . $package->width . ' x ' . $package->height }}</td>
                <td>{{ $package->weight }} lb(s)</td>
                <td>{{ $package->tracking_number }}</td>
                <td>{{ $package->invoice_number }}</td>
                <td>{{ $package->invoice_amount }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
