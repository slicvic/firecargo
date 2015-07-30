@extends('layouts.admin.page')

@section('title', 'Shipments')
@section('subtitle', 'Manage Your Shipments')
@section('actions')
    <a href="/shipments/create" class="btn btn-primary"><i class="fa fa-plus"></i> Create New Shipment</a>
@stop

@section('page_content')
<div class="ibox float-e-margins">
    <div class="ibox-content">
        <h2>
            @if ($params['search'])
                {{ $shipments->count() }} results found for: <span class="text-navy">"{{ $params['search'] }}"</span>
            @else
                Showing {{ $shipments->lastItem() ? $shipments->firstItem() : 0 }} - {{ $shipments->lastItem() }} of {{ $shipments->count() }} records
            @endif
        </h2>

        @include('shipments.index._search_form')

        <div class="clear hr-line-dashed"></div>

        @include('shipments.index._results_table')

        <div class="row">
            <div class="pull-right">
                {!! $shipments->appends(['sort' => $params['sort'], 'order' => $params['order']])->render() !!}
            </div>
        </div>
    </div>
</div>

<script src="/assets/admin/js/shipment-index.js"></script>
@stop
