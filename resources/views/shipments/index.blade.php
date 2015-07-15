@extends('layouts.admin.master')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Shipments</h2>
            Manage Your Shipments
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                <a href="/shipments/create" class="btn btn-primary"><i class="fa fa-plus"></i> Create New Shipment</a>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                {!! Flash::getHtml() !!}
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
                                    <th><a href="/shipments?sort=id&order={{ $oppositeOrder }}">Number {!! $input['sort'] == 'id' ? '<i class="fa fa-angle-' . ($input['order'] == 'asc' ? 'up' : 'down') . '"></i>' : '' !!}</a></th>
                                    <th>Pieces</th>
                                    <th>Reference Number</th>
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
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $('table').on('click', '.btn-toggle-packages', function() {
                var $btn = $(this);
                var $parentTr = $btn.closest('tr');
                $btn.toggleClass('collapsed');

                if ($btn.hasClass('collapsed')) {
                    var $packagesTr = $('<tr><td colspan="9"><h5 class="alert alert-warning text-center">Loading packages...</h5></td></tr>')
                    $parentTr.after($packagesTr);
                    $btn.html('<i class="fa fa-minus"></i>');
                    $.get('/packages/ajax-shipment-packages/' + $btn.attr('data-warehouse-id')).done(function(data) {
                        $packagesTr.find('td').html(data);
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
