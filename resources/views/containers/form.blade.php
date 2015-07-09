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
        <div class="form-group">
            <label class="control-label col-sm-2">Receipt #</label>
            <div class="col-sm-2">
                <select class="form-control">
                    @foreach (\App\Models\ContainerType::all() as $type)
                        <option>{{ $type->code }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-2">
                <input required type="text" name="container[receipt_number]" placeholder="" class="form-control" value="{{ Input::old('container.receipt_number', $container->receipt_number) }}">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Departure Date</label>
            <div class="col-sm-4">
                <input type="text" name="container[departed_at]" placeholder="" class="form-control" value="{{ Input::old('container.departed_at', ($container->id) ? $container->departed_at : date('Y-m-d H:i:s')) }}">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Carrier</label>
            <div class="col-sm-4">
                <input type="text" name="container[carrier]" placeholder="" class="form-control" value="">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Warehouse IDs</label>
            <div class="col-sm-4">
                @foreach (\App\Models\Warehouse::all() as $warehouse)
                    <div><input type="checkbox"> {{ $warehouse->id }} {{ $warehouse->present()->consignee() }}</div>
                    @foreach ($warehouse->packages as $package)
                        <div><input type="checkbox"> {{ $package->id }}</div>
                    @endforeach
                @endforeach
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
