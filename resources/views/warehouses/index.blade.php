@extends('layouts.admin.master')

@section('content')
<div class="row">
    <h3><i class="fa fa-@yield('icon')"></i> Warehouses</h3>
    <hr>
</div>

<div class="row filter-block">
    <div class="col-md-12">
		<a href="/warehouses/create" class="btn-flat primary">
			<i class="fa fa-plus"></i> New
		</a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
    	<form method="get" action="/warehouses">
	    	Search
	    	<input type="text" class="form-control" name="q">
	    	<button>Filter</button>
    	</form>

        <div class="pull-right">
            {!! $pagination = $warehouses->appends(['sortby' => $sortBy, 'order' => $sortOrder])->render() !!}
        </div>

        <table class="datatable table table-striped">
            <thead>
                <tr>
					<th><button class="expand-all-btn btn btn-default"><i class="fa fa-plus"></i></button></th>
					<th><a href="/warehouses?sortby=id&order={{ $reverseSortOrder }}">ID {!! $sortBy == 'id' ? '<i class="fa fa-angle-' . ($sortOrder == 'asc' ? 'up' : 'down') . '"></i>' : '' !!}</a></th>
                    <th><a href="/warehouses?sortby=date&order={{ $reverseSortOrder }}">Date {!! $sortBy == 'date' ? '<i class="fa fa-angle-' . ($sortOrder == 'asc' ? 'up' : 'down') . '"></i>' : '' !!}</a></th>
					<th>Pieces</th>
					<th>Gross Weight</th>
					<th>Volume</th>
					<th>Shipper</th>
					<th>Consignee</th>
					<th>Action</th>
                </tr>
            </thead>
            <tbody>
				@foreach ($warehouses as $warehouse)
				<tr>
					<td><button class="expand-row-btn btn btn-default" data-warehouse-id="{{ $warehouse->id }}"><i class="fa fa-plus"></i></button></td>
					<td>{{ $warehouse->prettyId() }}</td>
					<td>{{ $warehouse->prettyArrivedAt(FALSE) }}</td>
					<td><span class="badge badge-default">{{ $warehouse->countPackages() }}</span></td>
					<td>{{ $warehouse->calculateGrossWeight() }} lb(s)</td>
					<td>{{ $warehouse->calculateVolumeWeight() }} lb(s)</td>
					<td>{{ $warehouse->shipper ? $warehouse->shipper->business_name : '' }}</td>
					<td>{{ $warehouse->consignee ? $warehouse->consignee->getFullName() : '' }}</td>
					<td>
						<a href="/warehouses/view/{{ $warehouse->id }}" class="btn btn-default"><i class="fa fa-eye"></i></a>
						<a href="/warehouses/edit/{{ $warehouse->id }}" class="btn btn-default"><i class="fa fa-pencil"></i></a>
					</td>
				</tr>
				@endforeach
            </tbody>
        </table>
    </div>

    <div class="pull-right">
        {!! $pagination !!}
    </div>
</div>

<script>
    $(function() {
		$('.expand-all-btn').click(function() {
			$('.expand-row-btn').click();
		});

		/*
		$('table').dataTable({
			'bPaginate': true,
			'bLengthChange': true,
			'bFilter': true,
			'bSort': true,
			'bInfo': false,
			'bAutoWidth': false,
			'order': [[ 1, 'desc' ]]
		});
		*/

		$('table').on('click', '.expand-row-btn', function() {
			var $btn = $(this);
			var $parentTr = $btn.closest('tr');
			$btn.toggleClass('collapsed');

			if ($btn.hasClass('collapsed')) {
				var $packagesTr = $('<tr><td colspan="10"><div class="text-center col-sm-10 col-sm-offset-1"><h5 class="alert alert-warning">Loading...</h5></div></td></tr>')
				$parentTr.after($packagesTr);
				$btn.html('<i class="fa fa-minus"></i>');
				$.get('/warehouses/ajax-packages/' + $btn.attr('data-warehouse-id')).done(function(data) {
					$packagesTr.find('td > div').html(data);
					console.log(data);
				});
			}
			else {
				$parentTr.next().remove();
				$btn.html('<i class="fa fa-plus"></i>');
			}
		});
	});
</script>
@stop

