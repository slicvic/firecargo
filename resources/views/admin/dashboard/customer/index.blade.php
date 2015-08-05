@extends('admin.layouts.page')

@section('title', 'Dashboard')

@section('page_content')
<div class="ibox">
    <div class="ibox-content">
        <h2>My Packages</h2>
        <hr>
        <table class="table table-striped datatable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Status</th>
                    <th>Arrival Date</th>
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
                        <td>{!! $package->present()->statusText() !!}</td>
                        <td>{{ $package->present()->arrivalDate() }}</td>
                        <td>{{ $package->warehouse->shipper->name }}</td>
                        <td>{{ $package->tracking_number }}</td>
                        <td>{{ $package->present()->weight() }}</td>
                        <td>{{ $package->description }}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" data-package-id="{{ $package->id }}" class="show-package-modal-btn btn-white btn btn-sm">More Info</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

