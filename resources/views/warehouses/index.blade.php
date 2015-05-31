@extends('layouts.members.index')

@section('icon', 'cube')
@section('title', 'Warehouses')

@section('actions')
<a href="/warehouses/create" class="btn-flat primary">
    <i class="fa fa-plus"></i> New
</a>
@stop

@section('thead')
<th>ID</th>
<th>Date</th>
<th>Pieces</th>
<th>Weight</th>
<th>Volume</th>
<th>Shipper</th>
<th>Consignee</th>
<th>Actions</th>
@stop

@section('tbody')
	@foreach ($warehouses as $warehouse)
	<tr>
		<td>{{ $warehouse->prettyId() }}</td>
		<td>{{ $warehouse->prettyArrivedAt() }}</td>
		<td>{{ $warehouse->countPackages() }}</td>
		<td>{{ $warehouse->calculateGrossWeight() }} lb(s)</td>
		<td>{{ $warehouse->calculateVolumeWeight() }} lb(s)</td>
		<td>{{ $warehouse->shipper ? $warehouse->shipper->fullname() : '' }}</td>
		<td>{{ $warehouse->consignee ? $warehouse->consignee->fullname() : '' }}</td>
		<td>
			<a href="/warehouses/view/{{ $warehouse->id }}" class="btn btn-default"><i class="fa fa-eye"></i></a>
			<a href="/warehouses/edit/{{ $warehouse->id }}" class="btn btn-default"><i class="fa fa-pencil"></i></a>
		</td>
	</tr>
	@endforeach
@stop

@section('script')
$(function() {
	$('table').dataTable({
		'bPaginate': true,
		'bLengthChange': true,
		'bFilter': true,
		'bSort': true,
		'bInfo': false,
		'bAutoWidth': false,
		'order': [[ 1, 'desc' ]]
	});
});
@stop
