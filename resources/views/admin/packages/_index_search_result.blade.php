<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                @if ($isAdminUser)
                    <th>{!! Html::linkToSort('/packages', 'Company', 'company_id', $params['sort'], $params['order']) !!}</th>
                @endif
                <th>{!! Html::linkToSort('/packages', 'ID', 'id', $params['sort'], $params['order']) !!}</th>
                <th>{!! Html::linkToSort('/packages', 'Tracking #', 'tracking_number', $params['sort'], $params['order']) !!}</th>
                <th>{!! Html::linkToSort('/packages', 'Type', 'type_id', $params['sort'], $params['order']) !!}</th>
                <th>{!! Html::linkToSort('/packages', 'Weight', 'weight', $params['sort'], $params['order']) !!}</th>
                <th>{!! Html::linkToSort('/packages', 'Value', 'invoice_value', $params['sort'], $params['order']) !!}</th>
                <th>Description</th>
                <th>{!! Html::linkToSort('/packages', 'Warehouse', 'warehouse_id', $params['sort'], $params['order']) !!}</th>
                <th>{!! Html::linkToSort('/packages', 'Customer', 'customer_account_id', $params['sort'], $params['order']) !!}</th>
                <th>{!! Html::linkToSort('/packages', 'Shipment', 'shipment_id', $params['sort'], $params['order']) !!}</th>
                <th>{!! Html::linkToSort('/packages', 'Created', 'created_at', $params['sort'], $params['order']) !!}</th>
                <th>{!! Html::linkToSort('/packages', 'Modified', 'updated_at', $params['sort'], $params['order']) !!}</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($packages as $package)
                <tr class="{{ $package->present()->statusCssClass() }}">
                    @if ($isAdminUser) {!! '<td>' . $package->company->name . '</td>' !!} @endif
                    <td>{{ $package->id }}</td>
                    <td>{{ $package->tracking_number }}</td>
                    <td>{{ $package->type->name }}</td>
                    <td>{{ $package->present()->weight() }}</td>
                    <td>{{ $package->present()->value() }}</td>
                    <td>{{ $package->description }}</td>
                    <td>{!! $package->present()->warehouseLink() !!}</td>
                    <td>{!! $package->present()->customerLink() !!}</td>
                    <td>{!! $package->present()->shipmentLink() !!}</td>
                    <td>{{ $package->present()->createdAt() }}</td>
                    <td>{{ $package->present()->updatedAt() }}</td>
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
