@extends('admin.layouts.page')

@section('title', 'Accounts')
@section('subtitle', 'Manage Your Accounts')
@section('actions')
    <a href="/account/create" class="btn btn-primary"><i class="fa fa-plus"></i> Create New Account</a>
@stop

@section('page_content')
<div class="row">
    <div class="col-md-12">
        <div class="btn-group btn-group-lg" role="group" aria-label="Large button group">
            <a href="/accounts" class="btn {{ ($params['type'] === 'all') ? 'btn-primary' : 'btn-white' }}">All</a>
            <a href="/accounts?type=customers" class="btn {{ ($params['type'] === 'customers') ? 'btn-primary' : 'btn-white' }}">Customers</a>
            <a href="/accounts?type=shippers" class="btn {{ ($params['type'] === 'shippers') ? 'btn-primary' : 'btn-white' }}">Shippers</a>
        </div>
    </div>
</div>

<br>

<div class="ibox float-e-margins">
    <div class="ibox-content">
        <div class="row">
            <div class="col-md-12">
                <h2 class="pull-left">
                    @if ($params['search'])
                        {{ $accounts->count() }} results found for: <span class="text-navy">"{{ $params['search'] }}"</span>
                    @else
                        Showing {{ $accounts->lastItem() ? $accounts->firstItem() : 0 }} - {{ $accounts->lastItem() }} of {{ $accounts->total() }} records
                    @endif
                </h2>
            </div>
        </div>

        @include('admin.accounts._index_search_form')

        <div class="hr-line-dashed"></div>

        <div class="row">
            <div class="col-md-12">
                <div class="pull-right">
                    {!! $pagination = $accounts->appends(['type' => $params['type'], 'sort' => $params['sort'], 'order' => $params['order']])->render() !!}
                </div>
            </div>
        </div>

        @include('admin.accounts._index_search_result')

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
