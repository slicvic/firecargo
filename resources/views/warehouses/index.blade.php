@extends('layouts.admin.page')

@section('title', 'Warehouses')
@section('subtitle', 'Manage Your Warehouses')
@section('actions')
    <a href="/warehouses/create" class="btn btn-primary"><i class="fa fa-plus"></i> Create New Warehouse</a>
@stop

@section('page_content')
<div class="ibox float-e-margins">
    <div class="ibox-content">
        <h2>
            @if ($params['search'])
                {{ $warehouses->count() }} results found for: <span class="text-navy">"{{ $params['search'] }}"</span>
            @else
                Showing {{ $warehouses->lastItem() ? $warehouses->firstItem() : 0 }} - {{ $warehouses->lastItem() }} of {{ $warehouses->count() }} records
            @endif
        </h2>

        @include('warehouses.index._search_form')

        <div class="hr-line-dashed"></div>

        <div class="row">
            <div class="col-md-12">
                <div class="pull-right">
                    <i class="fa fa-circle text-danger"></i>&nbsp;&nbsp;Unprocessed &nbsp;&nbsp;
                    <i class="fa fa-circle text-warning"></i>&nbsp;&nbsp;Pending &nbsp;&nbsp;
                    <i class="fa fa-circle text-navy"></i>&nbsp;&nbsp;Complete
                </div>
            </div>
        </div>

        <div class="hr-line-dashed"></div>

        @include('warehouses.index._results_table')

        <div class="row">
            <div class="pull-right">
                {!! $warehouses->appends(['sort' => $params['sort'], 'order' => $params['order']])->render() !!}
            </div>
        </div>
    </div>
</div>

<script src="/assets/admin/js/warehouse-index.js"></script>
@stop
