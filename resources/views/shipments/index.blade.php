@extends('layouts.admin.page')

@section('title', 'Shipments')
@section('subtitle', 'Manage Your Shipments')
@section('actions')
    <a href="/shipments/create" class="btn btn-primary"><i class="fa fa-plus"></i> Create New Shipment</a>
@stop

@section('page_content')
<div class="ibox float-e-margins">
    <div class="ibox-content">
        <h2>
            @if ($input['q'])
                {{ $shipments->count() }} results found for: <span class="text-navy">"{{ $input['q'] }}"</span>
            @else
                Showing {{ $shipments->firstItem() }} - {{ $shipments->lastItem() }} of {{ $shipments->count() }} records
            @endif
        </h2>

        <div class="title-action">
            <form class="form-inline" method="get" action="/shipments">
                <div class="form-group">
                    <label>Search</label>
                    <input type="text" class="form-control" name="q" value="{{ $input['q'] }}">
                </div>
                @if ($input['q'])
                    <a href="/shipments" class="btn btn-md btn-white" type="submit">Clear</a>
                @endif
                <button class="btn btn-md btn-primary" type="submit">Search</button>
            </form>
        </div>

        <div class="clear hr-line-dashed"></div>

        <div class="pull-right">
            {!! $pagination = $shipments->appends(['sort' => $input['sort'], 'order' => $input['order']])->render() !!}
        </div>

        <table class="datatable table table-striped">
            <thead>
                <tr>
                    <th></th>
                    @if (Auth::user()->isAdmin()) {!! '<th>Master</th>' !!} @endif
                    <th><a href="/shipments?sort=id&order={{ $oppositeOrder }}">Number {!! $input['sort'] == 'id' ? '<i class="fa fa-angle-' . ($input['order'] == 'asc' ? 'up' : 'down') . '"></i>' : '' !!}</a></th>
                    <th>Pieces</th>
                    <th>Reference #</th>
                    <th>Carrier</th>
                    <th><a href="/shipments?sort=departed&order={{ $oppositeOrder }}">Departed {!! $input['sort'] == 'departed' ? '<i class="fa fa-angle-' . ($input['order'] == 'asc' ? 'up' : 'down') . '"></i>' : '' !!}</a></th>
                    <th><a href="/shipments?sort=created&order={{ $oppositeOrder }}">Created {!! $input['sort'] == 'created' ? '<i class="fa fa-angle-' . ($input['order'] == 'asc' ? 'up' : 'down') . '"></i>' : '' !!}</a></th>
                    <th><a href="/shipments?sort=updated&order={{ $oppositeOrder }}">Updated {!! $input['sort'] == 'updated' ? '<i class="fa fa-angle-' . ($input['order'] == 'asc' ? 'up' : 'down') . '"></i>' : '' !!}</a></th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($shipments as $shipment)
                <tr>
                    <td><button class="btn-toggle-packages btn btn-link btn-sm" data-warehouse-id="{{ $shipment->id }}"><i class="fa fa-plus"></i></button></td>
                    @if (Auth::user()->isAdmin()) {!! '<td>' . $shipment->company->name . '</td>' !!} @endif
                    <td>{{ $shipment->id }}</td>
                    <td><span class="label label-danger">{{ $shipment->packages()->count() }}</span></td>
                    <td>{{ $shipment->reference_number }}</td>
                    <td>{{ $shipment->present()->carrier() }}</td>
                    <td>{{ $shipment->present()->departedAt() }}</td>
                    <td>{{ $shipment->present()->createdAt() }}</td>
                    <td>{{ $shipment->present()->updatedAt() }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="/shipments/show/{{ $shipment->id }}" class="btn-white btn btn-sm">View</a>
                            <a href="/shipments/edit/{{ $shipment->id }}" class="btn-white btn btn-sm">Edit</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pull-right">
            {!! $pagination !!}
        </div>
    </div>
</div>

<script src="/assets/admin/js/pages/shipments/index.js"></script>
@stop
