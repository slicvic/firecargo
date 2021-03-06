<div id="shipments-table" class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th></th>
                @if ($isAdminUser)
                    <th>{!! Html::linkToSort('/shipments', 'Company', 'company_id', $params['sort'], $params['order']) !!}</th>
                @endif                <th>{!! Html::linkToSort('/shipments', 'ID', 'id', $params['sort'], $params['order']) !!}</th>
                <th>Pieces</th>
                <th>{!! Html::linkToSort('/shipments', 'Reference #', 'reference_number', $params['sort'], $params['order']) !!}</th>
                <th>{!! Html::linkToSort('/shipments', 'Carrier', 'carrier_id', $params['sort'], $params['order']) !!}</th>
                <th>{!! Html::linkToSort('/shipments', 'Departed', 'departed_at', $params['sort'], $params['order']) !!}</th>
                <th>{!! Html::linkToSort('/shipments', 'Created', 'created_at', $params['sort'], $params['order']) !!}</th>
                <th>{!! Html::linkToSort('/shipments', 'Modified', 'updated_at', $params['sort'], $params['order']) !!}</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($shipments as $shipment)
            <tr>
                <td><button class="toggle-packages-btn btn btn-link btn-sm" data-shipment-id="{{ $shipment->id }}"><i class="fa fa-angle-right"></i></button></td>
                @if ($isAdminUser) {!! '<td>' . $shipment->company->name . '</td>' !!} @endif
                <td>{{ $shipment->id }}</td>
                <td><span class="label label-info">{{ $shipment->packages()->count() }}</span></td>
                <td>{{ $shipment->reference_number }}</td>
                <td>{{ $shipment->present()->carrier() }}</td>
                <td>{{ $shipment->present()->departedAt() }}</td>
                <td>{{ $shipment->present()->createdAt() }}</td>
                <td>{{ $shipment->present()->updatedAt() }}</td>
                <td>
                    <div class="btn-group" style="min-width:100px;">
                        <a href="/shipment/{{ $shipment->id }}" class="btn-white btn btn-sm">View</a>
                        <a href="/shipment/{{ $shipment->id }}/edit" class="btn-white btn btn-sm">Edit</a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
