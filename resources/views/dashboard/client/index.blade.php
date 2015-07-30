@extends('layouts.admin.page')

@section('title', 'Dashboard')

@section('page_content')
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Type</th>
            <th>Tracking #</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($packages as $package)
            <tr>
                <td>{{ $package->id }}</td>
                <td>{{ $package->type->name }}</td>
                <td>{{ $package->tracking_number }}</td>
                <td>{{ str_limit($package->description, 50, '...') }}</td>
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
