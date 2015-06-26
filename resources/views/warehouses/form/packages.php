<?php $packages = $warehouse->packages(); ?>
<table id="packages" class="table table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th>Status</th>
            <th>Type</th>
            <th>Length</th>
            <th>Width</th>
            <th>Height</th>
            <th>Weight</th>
            <th>Action</th>
        </tr>
    </thead>
    <?php if (count($packages)): ?>
        <?php foreach ($packages as $package): ?>
            <?php echo view('warehouses.form.package', ['package' => $package]); ?>
        <?php endforeach; ?>
    <?php else: ?>
        <?php echo view('warehouses.form.package', ['package' => new \App\Models\Package()]); ?>
    <?php endif; ?>
</table>
