<div class="table-responsive">
    <table id="warehouses-table" class="table">
        <thead>
            <tr>
                <th></th>
                @if (Auth::user()->isAdmin()) {!! '<th>Company</th>' !!} @endif
                <th>{!! Html::linkToSort('/warehouses', 'ID', 'id', $params['sort'], $params['order']) !!}</th>
                <th>Pieces</th>
                <th>Gross Weight</th>
                <th>Volume</th>
                <th>Carrier</th>
                <th>Shipper</th>
                <th>Client</th>
                <th>{!! Html::linkToSort('/warehouses', 'Created', 'created_at', $params['sort'], $params['order']) !!}</th>
                <th>{!! Html::linkToSort('/warehouses', 'Updated', 'updated_at', $params['sort'], $params['order']) !!}</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($warehouses as $warehouse)
            <tr class="{{ $warehouse->present()->statusCssClass() }}">
                <td><button class="toggle-packages-btn btn btn-link btn-sm" data-warehouse-id="{{ $warehouse->id }}"><i class="fa fa-angle-right"></i></button></td>
                @if (Auth::user()->isAdmin()) {!! '<td>' . $warehouse->company->name . '</td>' !!} @endif
                <td>{{ $warehouse->id }}</td>
                <td><span class="label label-danger">{{ $warehouse->packages->count() }}</span></td>
                <td>{{ $warehouse->present()->grossWeight() }}</td>
                <td>{{ $warehouse->present()->volumeWeight() }}</td>
                <td>{{ $warehouse->present()->carrier() }}</td>
                <td>{!! $warehouse->present()->shipperLink() !!}</td>
                <td>{!! $warehouse->present()->clientLink() !!}</td>
                <td>{{ $warehouse->present()->createdAt() }}</td>
                <td>{{ $warehouse->present()->updatedAt() }}</td>
                <td>
                    <div class="btn-group" style="min-width:100px;">
                        <a href="/warehouses/show/{{ $warehouse->id }}" class="btn btn-sm btn-white">View</a>
                        <a href="/warehouses/edit/{{ $warehouse->id }}" class="btn btn-sm btn-white">Edit</a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
