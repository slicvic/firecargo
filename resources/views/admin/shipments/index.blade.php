@extends('admin.layouts.page')

@section('title', 'Shipments')
@section('subtitle', 'Manage Your Shipments')
@section('actions')
    <a href="/shipment/create" class="btn btn-primary"><i class="fa fa-plus"></i> Create New Shipment</a>
@stop

@section('page_content')
<div class="ibox float-e-margins">
    <div class="ibox-content">
        <h2>
            @if ($params['search'])
                {{ $shipments->count() }} results found for: <span class="text-navy">"{{ $params['search'] }}"</span>
            @else
                Showing {{ $shipments->lastItem() ? $shipments->firstItem() : 0 }} - {{ $shipments->lastItem() }} of {{ $shipments->total() }} records
            @endif
        </h2>

        @include('admin.shipments._index_search_form')

        <div class="clear hr-line-dashed"></div>

        <div class="row">
            <div class="col-md-12">
                <div class="pull-right">
                    {!! $pagination = $shipments->appends(['sort' => $params['sort'], 'order' => $params['order']])->render() !!}
                </div>
            </div>
        </div>

        @include('admin.shipments._index_search_result')

        <div class="row">
            <div class="col-md-12">
                <div class="pull-right">
                    {!! $pagination !!}
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/admin/js/shipment-index.js"></script>
@stop
