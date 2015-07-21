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
                    @if ($params['search'])
                        {{ $warehouses->count() }} results found for: <span class="text-navy">"{{ $params['search'] }}"</span>
                    @else
                        Showing {{ $warehouses->firstItem() }} - {{ $warehouses->lastItem() }} of {{ $warehouses->count() }} records
                    @endif
                </h2>

                <div class="title-action">
                    <form class="form-inline" method="get" action="/warehouses">
                        <div class="form-group">
                            <label>Search: </label>
                            <input type="text" class="form-control" name="search" value="{{ $params['search'] }}">
                        </div>
                        <div class="form-group">
                            <label>Status: </label>
                            <select class="form-control" name="status">
                                <option value="">All</option>
                                <option{{ $params['status'] == 'new' ? ' selected' : '' }} value="new">New</option>
                                <option{{ $params['status'] == 'pending' ? ' selected' : '' }} value="pending">Pending</option>
                                <option{{ $params['status'] == 'complete' ? ' selected' : '' }} value="complete">Complete</option>
                            </select>
                        </div>
                        @if ($params['search'] || $params['status'])
                            <a href="/warehouses" class="btn btn-md btn-white" type="submit">Clear</a>
                        @endif
                        <button class="btn btn-md btn-primary" type="submit">Search</button>
                    </form>
                </div>

                <div class="clear hr-line-dashed"></div>

                <div class="pull-right">
                    {!! $pagination = $warehouses->appends(['sort' => $params['sort'], 'order' => $params['order']])->render() !!}
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                @if (Auth::user()->isAdmin()) {!! '<th>Company</th>' !!} @endif
                                <th>{!! Html::linkToSorting('/warehouses', 'Number', 'id', $params['sort'], $params['order']) !!}</th>
                                <th>Pieces</th>
                                <th>Gross Weight</th>
                                <th>Volume</th>
                                <th>Carrier</th>
                                <th>Shipper</th>
                                <th>Consignee</th>
                                <th>{!! Html::linkToSorting('/warehouses', 'Arrived', 'arrived_at', $params['sort'], $params['order']) !!}</th>
                                <th>{!! Html::linkToSorting('/warehouses', 'Created', 'created_at', $params['sort'], $params['order']) !!}</th>
                                <th>{!! Html::linkToSorting('/warehouses', 'Updated', 'updated_at', $params['sort'], $params['order']) !!}</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($warehouses as $warehouse)
                            <tr class="{{ $warehouse->present()->colorStatus() }}">
                                <td><button class="btn-toggle-packages btn btn-link btn-sm" data-warehouse-id="{{ $warehouse->id }}"><i class="fa fa-plus"></i></button></td>
                                @if (Auth::user()->isAdmin()) {!! '<td>' . $warehouse->company->name . '</td>' !!} @endif
                                <td>{{ $warehouse->id }}</td>
                                <td><span class="label label-danger">{{ $warehouse->packages->count() }}</span></td>
                                <td>{{ $warehouse->present()->grossWeight() }}</td>
                                <td>{{ $warehouse->present()->volumeWeight() }}</td>
                                <td>{{ $warehouse->present()->carrier() }}</td>
                                <td>{!! $warehouse->present()->shipperLink() !!}</td>
                                <td>{!! $warehouse->present()->consigneeLink() !!}</td>
                                <td>{{ $warehouse->present()->arrivedAt(FALSE) }}</td>
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
                <div class="pull-right">
                    {!! $pagination !!}
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/admin/js/pages/warehouses/index.js"></script>
@stop
