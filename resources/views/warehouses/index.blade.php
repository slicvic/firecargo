@extends('layouts.admin.page')

@section('title', 'Warehouses')
@section('subtitle', 'Manage Your Warehouses')
@section('actions')
    <a href="/warehouses/create" class="btn btn-primary"><i class="fa fa-plus"></i> Create New Warehouse</a>
@stop

@section('page_content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <h2>
                    @if ($input['q'])
                        {{ $warehouses->count() }} results found for: <span class="text-navy">"{{ $input['q'] }}"</span>
                    @else
                        Showing {{ $warehouses->firstItem() }} - {{ $warehouses->lastItem() }} of {{ $warehouses->count() }} records
                    @endif
                </h2>

                <div class="title-action">
                    <form class="form-inline" method="get" action="/warehouses">
                        <div class="form-group">
                            <label>Search</label>
                            <input type="text" class="form-control" name="q" value="{{ $input['q'] }}">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="">All</option>
                                <option{{ $input['status'] == 'new' ? ' selected' : '' }} value="new">New</option>
                                <option{{ $input['status'] == 'pending' ? ' selected' : '' }} value="pending">Pending</option>
                                <option{{ $input['status'] == 'complete' ? ' selected' : '' }} value="complete">Complete</option>
                            </select>
                        </div>
                        @if ($input['q'] || $input['status'])
                            <a href="/warehouses" class="btn btn-md btn-white" type="submit">Clear</a>
                        @endif
                        <button class="btn btn-md btn-primary" type="submit">Search</button>
                    </form>
                </div>

                <div class="clear hr-line-dashed"></div>

                <div class="pull-right">
                    {!! $pagination = $warehouses->appends(['sort' => $input['sort'], 'order' => $input['order']])->render() !!}
                </div>

                <table class="datatable table table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th><a href="/warehouses?sort=id&order={{ $oppositeOrder }}">Number {!! $input['sort'] == 'id' ? '<i class="fa fa-angle-' . ($input['order'] == 'asc' ? 'up' : 'down') . '"></i>' : '' !!}</a></th>
                            <th>Pieces</th>
                            <th>Gross Weight</th>
                            <th>Volume</th>
                            <th>Shipper</th>
                            <th>Consignee</th>
                            <th><a href="/warehouses?sort=arrived&order={{ $oppositeOrder }}">Arrived {!! $input['sort'] == 'arrived' ? '<i class="fa fa-angle-' . ($input['order'] == 'asc' ? 'up' : 'down') . '"></i>' : '' !!}</a></th>
                            <th><a href="/warehouses?sort=created&order={{ $oppositeOrder }}">Created {!! $input['sort'] == 'created' ? '<i class="fa fa-angle-' . ($input['order'] == 'asc' ? 'up' : 'down') . '"></i>' : '' !!}</a></th>
                            <th><a href="/warehouses?sort=updated&order={{ $oppositeOrder }}">Updated {!! $input['sort'] == 'updated' ? '<i class="fa fa-angle-' . ($input['order'] == 'asc' ? 'up' : 'down') . '"></i>' : '' !!}</a></th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($warehouses as $warehouse)
                        <tr class="{{ $warehouse->present()->colorStatus() }}">
                            <td><button class="btn-toggle-packages btn btn-link btn-sm" data-warehouse-id="{{ $warehouse->id }}"><i class="fa fa-plus"></i></button></td>
                            <td>{{ $warehouse->id }}</td>
                            <td><span class="label label-danger">{{ $warehouse->packages->count() }}</span></td>
                            <td>{{ $warehouse->present()->grossWeight() }}</td>
                            <td>{{ $warehouse->present()->volumeWeight() }}</td>
                            <td>{!! $warehouse->present()->shipperLink() !!}</td>
                            <td>{!! $warehouse->present()->consigneeLink() !!}</td>
                            <td>{{ $warehouse->present()->arrivedAt(FALSE) }}</td>
                            <td>{{ $warehouse->present()->createdAt() }}</td>
                            <td>{{ $warehouse->present()->updatedAt() }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="/warehouses/show/{{ $warehouse->id }}" class="btn btn-sm btn-white">View</a>
                                    <a href="/warehouses/edit/{{ $warehouse->id }}" class="btn btn-sm btn-white">Edit</a>
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
    </div>
</div>

<script src="/assets/admin/js/pages/warehouses/index.js"></script>
@stop
