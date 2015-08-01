@extends('layouts.admin.page')

@section('title', 'Warehouses')
@section('subtitle', 'Manage Your Consolidation Warehouses')
@section('actions')
    <a href="/warehouses/create" class="btn btn-primary"><i class="fa fa-plus"></i> Create New Warehouse</a>
@stop

@section('page_content')
<div class="ibox float-e-margins">
    <div class="ibox-content">
        <div class="row">
            <div class="col-md-12">
                <h2 class="pull-left">
                    @if ($params['search'])
                        {{ $warehouses->count() }} results found for: <span class="text-navy">"{{ $params['search'] }}"</span>
                    @else
                        Showing {{ $warehouses->lastItem() ? $warehouses->firstItem() : 0 }} - {{ $warehouses->lastItem() }} of {{ $warehouses->total() }} records
                    @endif
                </h2>
                <div class="pull-right">
                    <i class="fa fa-circle text-danger"></i>&nbsp;&nbsp;<span data-toggle="tooltip" data-placement="bottom" title="All pieces in warehouse awaiting shipment.">Unprocessed</span>&nbsp;&nbsp;
                    <i class="fa fa-circle text-warning"></i>&nbsp;&nbsp;<span data-toggle="tooltip" data-placement="bottom" title="Some pieces in warehouse awaiting shipment.">Pending</span>&nbsp;&nbsp;
                    <i class="fa fa-circle text-navy"></i>&nbsp;&nbsp;<span data-toggle="tooltip" data-placement="bottom" title="All pieces in warehouse shipped.">Complete</span>
                </div>
            </div>
        </div>

        @include('warehouses._index_search_form')

        <div class="hr-line-dashed"></div>

        <div class="row">
            <div class="col-md-12">
                <div class="pull-right">
                    {!! $pagination = $warehouses->appends(['sort' => $params['sort'], 'order' => $params['order']])->render() !!}
                </div>
            </div>
        </div>

        @include('warehouses._index_search_results')

        <div class="row">
            <div class="col-md-12">
                <div class="pull-right">
                    {!! $pagination !!}
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/admin/js/warehouse-index.js"></script>
@stop
