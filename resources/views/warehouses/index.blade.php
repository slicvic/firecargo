@extends('layouts.admin.master')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Warehouses</h2>
            Manage Your Warehouses
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                <a href="/warehouses/create" class="btn btn-primary"><i class="fa fa-plus"></i> Create New Warehouse</a>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                {!! \App\Helpers\Flash::getAsHTML() !!}
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        @if ($input['q'])
                            <h2>{{ $warehouses->count() }} results found for: <span class="text-navy">"{{ $input['q'] }}"</span></h2>
                        @endif
                        <div class="title-action">
                            <form class="form-inline pull-sright" method="get" action="/warehouses">
                                <div class="form-group">
                                    <label>Search</label>
                                    <input type="text" class="form-control" name="q" value="{{ $input['q'] }}">
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option value="">All</option>
                                        <option{{ $input['status'] == 'pending' ? ' selected' : '' }} value="pending">Pending</option>
                                        <option{{ $input['status'] == 'processed' ? ' selected' : '' }} value="processed">Processed</option>
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
                            {!! $pagination = $warehouses->appends(['sortby' => $input['sortby'], 'order' => $input['order']])->render() !!}
                        </div>

                        <table class="datatable table table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th><a href="/warehouses?sortby=id&order={{ $orderInverse }}">ID {!! $input['sortby'] == 'id' ? '<i class="fa fa-angle-' . ($input['order'] == 'asc' ? 'up' : 'down') . '"></i>' : '' !!}</a></th>
                                    <th>Pieces</th>
                                    <th>Gross Weight</th>
                                    <th>Volume</th>
                                    <th>Shipper</th>
                                    <th>Consignee</th>
                                    <th><a href="/warehouses?sortby=arrived&order={{ $orderInverse }}">Arrived {!! $input['sortby'] == 'arrived' ? '<i class="fa fa-angle-' . ($input['order'] == 'asc' ? 'up' : 'down') . '"></i>' : '' !!}</a></th>
                                    <th><a href="/warehouses?sortby=created&order={{ $orderInverse }}">Created {!! $input['sortby'] == 'created' ? '<i class="fa fa-angle-' . ($input['order'] == 'asc' ? 'up' : 'down') . '"></i>' : '' !!}</a></th>
                                    <th><a href="/warehouses?sortby=updated&order={{ $orderInverse }}">Updated {!! $input['sortby'] == 'updated' ? '<i class="fa fa-angle-' . ($input['order'] == 'asc' ? 'up' : 'down') . '"></i>' : '' !!}</a></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($warehouses as $warehouse)
                                <tr class="{{ $warehouse->present()->colorStatus() }}">
                                    <td><button class="btn-expand-row btn btn-link btn-sm" data-warehouse-id="{{ $warehouse->id }}"><i class="fa fa-plus"></i></button></td>
                                    <td>{{ $warehouse->id }}</td>
                                    <td><span class="label label-success">{{ $warehouse->packages->count() }}</span></td>
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
    </div>

    <script>
        $(function() {
            $('table').on('click', '.btn-expand-row', function() {
                var $btn = $(this);
                var $parentTr = $btn.closest('tr');
                $btn.toggleClass('collapsed');

                if ($btn.hasClass('collapsed')) {
                    var $packagesTr = $('<tr><td colspan="12"><div class="text-center col-sm-10 col-sm-offset-1"><h5 class="alert alert-warning">Loading...</h5></div></td></tr>')
                    $parentTr.after($packagesTr);
                    $btn.html('<i class="fa fa-minus"></i>');
                    $.get('/packages/ajax-warehouse-packages/' + $btn.attr('data-warehouse-id')).done(function(data) {
                        $packagesTr.find('td > div').html(data);
                    });
                }
                else {
                    $parentTr.next().remove();
                    $btn.html('<i class="fa fa-plus"></i>');
                }
            });
        });
    </script>
@stop
