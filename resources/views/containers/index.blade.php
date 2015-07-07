@extends('layouts.admin.master')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Containers</h2>
        Manage Containers
    </div>
    <div class="col-sm-8">
        <div class="title-action">
            <a href="/containers/create" class="btn btn-primary"><i class="fa fa-plus"></i> Create New Container</a>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            {!! \App\Helpers\Flash::getHTML() !!}
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    @if ($input['q'])
                        <h2>{{ $containers->count() }} results found for: <span class="text-navy">"{{ $input['q'] }}"</span></h2>
                    @endif
                    <div class="title-action">
                        <form class="form-inline pull-sright" method="get" action="/containers">
                            <div class="form-group">
                                <label>Search</label>
                                <input type="text" class="form-control" name="q" value="{{ $input['q'] }}">
                            </div>
                            @if ($input['q'])
                                <a href="/containers" class="btn btn-md btn-white" type="submit">Clear</a>
                            @endif
                            <button class="btn btn-md btn-primary" type="submit">Search</button>
                        </form>
                    </div>

                    <div class="clear hr-line-dashed"></div>

                    <div class="pull-right">
                        {!! $pagination = $containers->appends(['sortby' => $input['sortby'], 'order' => $input['order']])->render() !!}
                    </div>

                    <table class="datatable table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tracking Number</th>
                                <th>Departure Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($containers as $container)
                            <tr>
                                <td>{{ $container->id }}</td>
                                <td>{{ $container->tracking_number }}</td>
                                <td>{{ $container->departed_at }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="/containers/edit/{{ $container->id }}" class="btn-white btn btn-sm">Edit</a>
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
