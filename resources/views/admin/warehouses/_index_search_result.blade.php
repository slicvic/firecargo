<div class="table-responsive">
    <table id="warehouses-table" class="table">
        <thead>
            <tr>
                <th></th>
                @if ($isAdminUser)
                    <th>{!! Html::linkToSort('/warehouses', 'Company', 'company_id', $params['sort'], $params['order']) !!}</th>
                @endif
                <th>{!! Html::linkToSort('/warehouses', 'ID', 'id', $params['sort'], $params['order']) !!}</th>
                <th>Pieces</th>
                <th>Gross Weight</th>
                <th>Volume</th>
                <th>{!! Html::linkToSort('/warehouses', 'Customer', 'customer_account_id', $params['sort'], $params['order']) !!}</th>
                <th>{!! Html::linkToSort('/warehouses', 'Shipper', 'shipper_account_id', $params['sort'], $params['order']) !!}</th>
                <th>{!! Html::linkToSort('/warehouses', 'Carrier', 'carrier_id', $params['sort'], $params['order']) !!}</th>
                <th>{!! Html::linkToSort('/warehouses', 'Created', 'created_at', $params['sort'], $params['order']) !!}</th>
                <th>{!! Html::linkToSort('/warehouses', 'Modified', 'updated_at', $params['sort'], $params['order']) !!}</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($warehouses as $warehouse)
            <tr class="{{ $warehouse->present()->statusCssClass() }}">
                <td><button class="toggle-packages-btn btn btn-link btn-sm" data-warehouse-id="{{ $warehouse->id }}"><i class="fa fa-angle-right"></i></button></td>
                @if ($isAdminUser) {!! '<td>' . $warehouse->company->name . '</td>' !!} @endif
                <td>{{ $warehouse->id }}</td>
                <td><span class="label label-info">{{ $warehouse->packages->count() }}</span></td>
                <td>{{ $warehouse->present()->grossWeight() }}</td>
                <td>{{ $warehouse->present()->volumeWeight() }}</td>
                <td>{!! $warehouse->present()->customerLink() !!}</td>
                <td>{!! $warehouse->present()->shipperLink() !!}</td>
                <td>{{ $warehouse->present()->carrier() }}</td>
                <td>{{ $warehouse->present()->createdAt() }}</td>
                <td>{{ $warehouse->present()->updatedAt() }}</td>
                <td>
                    <div class="btn-group" style="min-width:100px;">
                        <a href="/warehouse/{{ $warehouse->id }}" class="btn btn-sm btn-white">View</a>
                        <a href="/warehouse/{{ $warehouse->id }}/edit" class="btn btn-sm btn-white">Edit</a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
