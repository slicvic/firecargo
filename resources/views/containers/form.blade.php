@extends('layouts.admin.model.form')

@section('icon', 'truck')

@section('title')
    {{ $container->id ? 'Edit' : 'Create' }} Container
@stop

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="/containers">Containers</a>
        </li>
        <li class="active">
            <strong>{{ $container->id ? 'Edit' : 'Create' }}</strong>
        </li>
    </ol>
@stop

@section('form')
    <form data-parsley-validate action="/containers/{{ ($container->id) ? 'update/' . $container->id : 'store' }}" method="post" class="form-horizontal">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="company_id" value="{{ ($container->id) ? $container->company_id : Auth::user()->company_id }}">
        <div class="form-group">
            <label class="control-label col-sm-2">Tracking Number</label>
            <div class="col-sm-4">
                <input required type="text" name="container[tracking_number]" placeholder="" class="form-control" value="{{ Input::old('container.tracking_number', $container->tracking_number) }}">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Departure Date</label>
            <div class="col-sm-4">
                <input type="text" name="container[departed_at]" placeholder="" class="form-control" value="{{ Input::old('container.departed_at', ($container->id) ? $container->departed_at : date('Y-m-d H:i:s')) }}">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Warehouse IDs</label>
            <div class="col-sm-4">
                <textarea name="warehouse_ids" rows="11" class="form-control">{{ Input::old('warehouse_ids', implode("\n", $container->warehouseIds())) }}</textarea>
                <p class="help-block">Line separated warehouse IDs.</p>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-2">
                <a class="btn btn-white" href="/containers">Cancel</a>
                <button class="btn btn-primary" type="submit">Save changes</button>
            </div>
        </div>
    </form>
@stop
