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
                <td>{{ ($type = $package->type) ? $type->name: '' }}</td>
                <td>{{ ($status = $package->status) ? $status->name : '' }}</td>
                <td>{{ $package->length . ' x ' . $package->width . ' x ' . $package->height }}</td>
                <td>{{ $package->weight }} lb(s)</td>
                <td>{{ $package->tracking_number }}</td>
                <td>{{ $package->invoice_number }}</td>
                <td>{{ $package->invoice_amount }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
