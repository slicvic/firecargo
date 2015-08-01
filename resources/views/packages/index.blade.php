@extends('layouts.admin.page')

@section('title', 'Pieces')
@section('subtitle', 'Manage Your Warehouse Pieces')

@section('page_content')
<div class="ibox float-e-margins">
    <div class="ibox-content">
        <div class="row">
            <div class="col-md-12">
                <h2 class="pull-left">
                    @if ($params['search'])
                        {{ $packages->count() }} results found for: <span class="text-navy">"{{ $params['search'] }}"</span>
                    @else
                        Showing {{ $packages->lastItem() ? $packages->firstItem() : 0 }} - {{ $packages->lastItem() }} of {{ $packages->total() }} records
                    @endif
                </h2>
                <div class="pull-right">
                    <i class="fa fa-circle text-danger"></i>&nbsp;&nbsp;Unprocessed &nbsp;&nbsp;
                    <i class="fa fa-circle text-warning"></i>&nbsp;&nbsp;On Hold Per Client&nbsp;&nbsp;
                    <i class="fa fa-circle text-navy"></i>&nbsp;&nbsp;Shipped
                </div>
            </div>
        </div>

        @include('packages._index_search_form')

        <div class="hr-line-dashed"></div>

        <div class="row">
            <div class="col-md-12">
                <div class="pull-right">
                    {!! $pagination = $packages->appends(['sort' => $params['sort'], 'order' => $params['order']])->render() !!}
                </div>
            </div>
        </div>

        @include('packages._index_search_results')

        <div class="row">
            <div class="col-md-12">
                <div class="pull-right">
                    {!! $pagination !!}
                </div>
            </div>
        </div>
    </div>
</div>

@stop