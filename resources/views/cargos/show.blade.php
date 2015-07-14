@extends('layouts.admin.master')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2>Cargo # {{ $cargo->id }}</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/cargos">Cargos</a>
            </li>
            <li class="active">
                <strong>Detail</strong>
            </li>
        </ol>
    </div>
    <div class="col-sm-8">
        <div class="title-action">
            <a href="/cargos/edit/{{ $cargo->id }}" class="btn btn-primary"><i class="fa fa-pencil"></i> Edit</a>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-md-9">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Pieces</h5>
                </div>
                <div class="ibox-content">
                    {!! view('packages._list_cargo', ['packages' => $cargo->packages]) !!}
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Summary</h5>
                </div>
                <div class="ibox-content">
                    <table class="table table-responsive">
                        <tr>
                            <th class="col-sm-2">ID</th>
                            <td>{{ $cargo->id }}</td>
                        </tr>
                        <tr>
                            <th>Reference #</th>
                            <td>{{ $cargo->reference_number }}</td>
                        </tr>
                        <tr>
                            <th>Departed</th>
                            <td>{{ $cargo->present()->departedAt() }}</td>
                        </tr>
                        <tr>
                            <th>Carrier</th>
                            <td>{{ $cargo->present()->carrier() }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
