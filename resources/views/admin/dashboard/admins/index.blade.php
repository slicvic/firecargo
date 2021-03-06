@extends('admin.layouts.master')

@section('content')
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h3 class="text-center">Warehouses</h3>
                            <div style="height:200px" id="warehouses-morris-donut-chart"></div>
                            <ul class="category-list">
                                <li><a href="/warehouses?status=1" data-toggle="tooltip" data-placement="bottom" title="All pieces in warehouse awaiting shipment."> <i class="fa fa-circle text-danger"></i> Unprocessed ({{ $totals['warehouses']['unprocessed'] }})</a></li>
                                <li><a href="/warehouses?status=2" data-toggle="tooltip" data-placement="bottom" title="Some pieces in warehouse awaiting shipment."> <i class="fa fa-circle text-warning"></i> Pending ({{ $totals['warehouses']['pending'] }})</a></li>
                                <li><a href="/warehouses?status=3" data-toggle="tooltip" data-placement="bottom" title="All pieces in warehouse shipped."> <i class="fa fa-circle text-navy"></i> Complete ({{ $totals['warehouses']['complete'] }})</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h3 class="text-center">Pieces</h3>
                            <div style="height:200px" id="packages-morris-donut-chart"></div>
                            <ul class="category-list">
                                <li><a href="/packages?status=unprocessed" data-toggle="tooltip" data-placement="left" title="Pieces awaiting shipment."> <i class="fa fa-circle text-danger"></i> Unprocessed ({{ $totals['packages']['unprocessed'] }})</a></li>
                                <li><a href="/packages?status=hold" data-toggle="tooltip" data-placement="left" title="Pieces on hold as per customer's request."> <i class="fa fa-circle text-warning"></i> On Hold ({{ $totals['packages']['hold'] }})</a></li>
                                <li><a href="/packages?status=shipped" data-toggle="tooltip" data-placement="left" title="Pieces shipped."> <i class="fa fa-circle text-navy"></i> Shipped ({{ $totals['packages']['shipped'] }})</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="/assets/plugins/inspinia/Static_Seed_Project/js/plugins/morris/raphael-2.1.0.min.js"></script>
<script src="/assets/plugins/inspinia/Static_Seed_Project/js/plugins/morris/morris.js"></script>
<script src="/assets/plugins/inspinia/Static_Seed_Project/js/plugins/sparkline/jquery.sparkline.min.js"></script>

<script>
$(function() {
    Morris.Donut({
        element: 'warehouses-morris-donut-chart',
        data: [
            { label: "Unprocessed", value: '{{ $totals['warehouses']['unprocessed'] }}' },
            { label: "Pending", value: '{{ $totals['warehouses']['pending'] }}' },
            { label: "Complete", value: '{{ $totals['warehouses']['complete'] }}' }
        ],
        resize: false,
        colors: ['#ed5565', '#f8ac59','#1ab394'],
    });

    Morris.Donut({
        element: 'packages-morris-donut-chart',
        data: [
            { label: "Unprocessed", value: '{{ $totals['packages']['unprocessed'] }}' },
            { label: "On Hold", value: '{{ $totals['packages']['hold'] }}' },
            { label: "Shipped", value: '{{ $totals['packages']['shipped'] }}' }
         ],
        resize: false,
        colors: ['#ed5565', '#f8ac59', '#1ab394'],
    });
});
</script>
@stop
