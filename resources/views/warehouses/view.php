<div class="row">
    <h3>
        <i class="fa fa-cube"></i> Warehouse # <?php echo $warehouse->id; ?>
        <a href="/warehouses/edit/<?php echo $warehouse->id; ?>" class="btn-flat primary"><i class="fa fa-pencil"></i> Edit</a>
    </h3>
    <hr>
</div>

<table class="table table-striped">
    <tr>
        <th>Date</th>
        <td><?php echo $warehouse->arrived_at; ?></td>
    </tr>
    <tr>
        <th>Shipper</th>
        <td><?php echo $warehouse->shipper->name(); ?></td>
    </tr>
    <tr>
        <th>Consignee</th>
        <td><?php echo $warehouse->consignee->name(); ?></td>
    </tr>
    <tr>
        <th>Delivered By</th>
        <td><?php echo $warehouse->deliveredBy->name; ?></td>
    </tr>
</table>

<h3>Packages</h3>
<table class="table table-striped">
    <tr>
        <th>ID</th>
        <th>Tracking #</th>
        <th>Type</th>
        <th>Length</th>
        <th>Width</th>
        <th>Height</th>
        <th>Weight</th>
        <th>Description</th>
        <th>Invoice #</th>
        <th>Invoice $</th>
    </tr>
    <?php foreach ($warehouse->packages as $package): ?>
        <tr>
            <td><?php echo $package->id; ?></td>
            <td><?php echo $package->tracking_number; ?></td>
            <td><?php echo $package->type->name; ?></td>
            <td><?php echo $package->length; ?></td>
            <td><?php echo $package->width; ?></td>
            <td><?php echo $package->height; ?></td>
            <td><?php echo $package->weight; ?></td>
            <td><?php echo $package->description; ?></td>
            <td><?php echo $package->invoice_number; ?></td>
            <td><?php echo $package->invoice_amount; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
