@extends('layouts.admin.page')

@section('title', 'Dashboard')

@section('page_content')
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Arrived</th>
            <th>Shipper</th>
            <th>Tracking Number</th>
            <th>Weight</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($packages as $package)
            <tr>
                <td>{{ $package->id }}</td>
                <td>{{ date('m/d/y g:i A', strtotime($package->created_at)) }}</td>
                <td>{{ $package->warehouse->shipper->name }}</td>
                <td>{{ $package->tracking_number }}</td>
                <td>{{ $package->present()->weight() }}</td>
                <td>{{ $package->description }}</td>
                <td>
                    <div class="btn-group">
                        <button type="button" data-package-id="{{ $package->id }}" class="show-package-modal-btn btn-white btn btn-sm">Detail</button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@stop

