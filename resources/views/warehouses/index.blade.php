@extends('layouts.admin.master')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Warehouses</h2>
        Manage Warehouses
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
            {!! \App\Helpers\Flash::getHTML() !!}
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form method="get" action="/warehouses">
                        Search
                        <input type="text" class="form-control" name="q">
                        <button>Filter</button>
                    </form>

                    <div class="pull-right">
                        {!! $pagination = $warehouses->appends(['sortby' => $sortBy, 'order' => $sortOrder])->render() !!}
                    </div>

                    <table class="datatable table table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th><a href="/warehouses?sortby=id&order={{ $reverseSortOrder }}">ID {!! $sortBy == 'id' ? '<i class="fa fa-angle-' . ($sortOrder == 'asc' ? 'up' : 'down') . '"></i>' : '' !!}</a></th>
                                <th><a href="/warehouses?sortby=date&order={{ $reverseSortOrder }}">Date {!! $sortBy == 'date' ? '<i class="fa fa-angle-' . ($sortOrder == 'asc' ? 'up' : 'down') . '"></i>' : '' !!}</a></th>
                                <th>Pieces</th>
                                <th>Gross Weight</th>
                                <th>Volume</th>
                                <th>Shipper</th>
                                <th>Consignee</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($warehouses as $warehouse)
                            <tr>
                                <td><button class="btn-expand-row btn btn-white btn-sm" data-warehouse-id="{{ $warehouse->id }}"><i class="fa fa-plus"></i></button></td>
                                <td>{{ $warehouse->id }}</td>
                                <td>{{ $warehouse->present()->arrivalDate(FALSE) }}</td>
                                <td><span class="label label-primary">{{ $warehouse->packages->count() }}</span></td>
                                <td>{{ $warehouse->present()->grossWeight() }}</td>
                                <td>{{ $warehouse->present()->volumeWeight() }}</td>
                                <td>{{ $warehouse->present()->shipperName() }}</td>
                                <td>{{ $warehouse->present()->consigneeName() }}</td>
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
                var $packagesTr = $('<tr><td colspan="10"><div class="text-center col-sm-10 col-sm-offset-1"><h5 class="alert alert-warning">Loading...</h5></div></td></tr>')
                $parentTr.after($packagesTr);
                $btn.html('<i class="fa fa-minus"></i>');
                $.get('/warehouses/ajax-packages/' + $btn.attr('data-warehouse-id')).done(function(data) {
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
