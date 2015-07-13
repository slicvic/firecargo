@extends('layouts.admin.master')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Cargos</h2>
            Manage Your Cargos
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                <a href="/cargos/create" class="btn btn-primary"><i class="fa fa-plus"></i> Create New Cargo</a>
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
                            <h2>{{ $cargos->count() }} results found for: <span class="text-navy">"{{ $input['q'] }}"</span></h2>
                        @endif
                        <div class="title-action">
                            <form class="form-inline pull-sright" method="get" action="/cargos">
                                <div class="form-group">
                                    <label>Search</label>
                                    <input type="text" class="form-control" name="q" value="{{ $input['q'] }}">
                                </div>
                                @if ($input['q'])
                                    <a href="/cargos" class="btn btn-md btn-white" type="submit">Clear</a>
                                @endif
                                <button class="btn btn-md btn-primary" type="submit">Search</button>
                            </form>
                        </div>

                        <div class="clear hr-line-dashed"></div>

                        <div class="pull-right">
                            {!! $pagination = $cargos->appends(['sortby' => $input['sortby'], 'order' => $input['order']])->render() !!}
                        </div>

                        <table class="datatable table table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th><a href="/cargos?sortby=id&order={{ $orderInverse }}">ID {!! $input['sortby'] == 'id' ? '<i class="fa fa-angle-' . ($input['order'] == 'asc' ? 'up' : 'down') . '"></i>' : '' !!}</a></th>
                                    <th>Receipt Number</th>
                                    <th>Carrier</th>
                                    <th><a href="/cargos?sortby=departed&order={{ $orderInverse }}">Departed {!! $input['sortby'] == 'departed' ? '<i class="fa fa-angle-' . ($input['order'] == 'asc' ? 'up' : 'down') . '"></i>' : '' !!}</a></th>
                                    <th><a href="/cargos?sortby=created&order={{ $orderInverse }}">Created {!! $input['sortby'] == 'created' ? '<i class="fa fa-angle-' . ($input['order'] == 'asc' ? 'up' : 'down') . '"></i>' : '' !!}</a></th>
                                    <th><a href="/cargos?sortby=updated&order={{ $orderInverse }}">Updated {!! $input['sortby'] == 'updated' ? '<i class="fa fa-angle-' . ($input['order'] == 'asc' ? 'up' : 'down') . '"></i>' : '' !!}</a></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cargos as $cargo)
                                <tr>
                                    <td><button class="btn-expand-row btn btn-link btn-sm" data-warehouse-id="{{ $cargo->id }}"><i class="fa fa-plus"></i></button></td>
                                    <td>{{ $cargo->id }}</td>
                                    <td>{{ $cargo->receipt_number }}</td>
                                    <td>{{ $cargo->present()->carrier() }}</td>
                                    <td>{{ $cargo->present()->departedAt() }}</td>
                                    <td>{{ $cargo->present()->createdAt() }}</td>
                                    <td>{{ $cargo->present()->updatedAt() }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="/cargos/show/{{ $cargo->id }}" class="btn-white btn btn-sm">View</a>
                                            <a href="/cargos/edit/{{ $cargo->id }}" class="btn-white btn btn-sm">Edit</a>
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
                    var $packagesTr = $('<tr><td colspan="8"><div class="text-center col-sm-10 col-sm-offset-1"><h5 class="alert alert-warning">Loading packages...</h5></div></td></tr>')
                    $parentTr.after($packagesTr);
                    $btn.html('<i class="fa fa-minus"></i>');
                    $.get('/packages/ajax-cargo-packages/' + $btn.attr('data-warehouse-id')).done(function(data) {
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
