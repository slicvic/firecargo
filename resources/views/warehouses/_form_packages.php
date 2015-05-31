<?php $packages = $warehouse->packages(); ?>
<table id="packagesTable" class="table table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th>Type</th>
            <th>Status</th>
            <th>Length</th>
            <th>Width</th>
            <th>Height</th>
            <th>Weight</th>
            <th>Description</th>
            <th>Invoice #</th>
            <th>Invoice $</th>
            <th>Tracking #</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($packages)): ?>
            <?php foreach ($packages as $package): ?>
                <?php echo view('warehouses._form_package_inline_form', ['package' => $package]); ?>
            <?php endforeach; ?>
        <?php else: ?>
            <?php echo view('warehouses._form_package_inline_form', ['package' => new \App\Models\Package()]); ?>
        <?php endif; ?>
    </tbody>
</table>
