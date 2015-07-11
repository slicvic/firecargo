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
                                <th>ID</th>
                                <th>Receipt Number</th>
                                <th>Departure Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cargos as $cargo)
                            <tr>
                                <td>{{ $cargo->id }}</td>
                                <td>{{ $cargo->receipt_number }}</td>
                                <td>{{ $cargo->departed_at }}</td>
                                <td>
                                    <div class="btn-group">
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

@stop
