@extends('layouts.admin.page')

@section('icon', 'fa fa-th-large')
@section('title', 'Dashboard')

@section('page_content')
<div class="row">
    <div class="col-lg-4">
        <div class="row">
            <div class="col-xs-3">
                <a class="btn btn-danger btn-circle btn-lg" href="/warehouses?status_id=1">{{ $totals['unprocessed'] }}</a>
            </div>
            <div class="col-xs-6">
                <h3>unprocessed warehouses</h3>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="row">
            <div class="col-xs-3">
                <a class="btn btn-warning btn-circle btn-lg" href="/warehouses?status_id=2">{{ $totals['pending'] }}</a>
            </div>
            <div class="col-xs-6">
                <h3>pending warehouses</h3>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="row">
            <div class="col-xs-3">
                <a class="btn btn-primary btn-circle btn-lg" href="/warehouses?status_id=3">{{ $totals['complete'] }}</a>
            </div>
            <div class="col-xs-6">
                <h3>complete warehouses</h3>
            </div>
        </div>
    </div>
</div>
@stop
