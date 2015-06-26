<?php $package_id = ($package->id) ? $package->id : 0; ?>
<tbody>
    <tr>
        <td>
            <select name="package[<?php echo $package_id; ?>][status_id]" data-name="status_id" class="form-control">
                <?php foreach(\App\Models\PackageStatus::allByCurrentSiteId('is_default', 'desc') as $status): ?>
                    <option<?php echo ($package->status_id == $status->id) ? ' selected' : ''; ?> value="<?php echo $status->id; ?>"><?php echo $status->name; ?></option>
                <?php endforeach; ?>
            </select>
        </td>
        <td>
            <select name="package[<?php echo $package_id; ?>][type_id]" data-name="type_id" class="form-control">
                <?php foreach(\App\Models\PackageType::allByCurrentSiteId() as $type): ?>
                    <option<?php echo ($package->type_id == $type->id) ? ' selected' : ''; ?> value="<?php echo $type->id; ?>"><?php echo $type->name; ?></option>
                <?php endforeach; ?>
            </select>
        </td>
        <td>
            <input type="text" name="package[<?php echo $package_id; ?>][length]" data-name="length" class="metric form-control" size="5" value="<?php echo $package->length; ?>">
        </td>
        <td>
            <input type="text" name="package[<?php echo $package_id; ?>][width]" data-name="width" class="metric form-control" size="5" value="<?php echo $package->width; ?>">
        </td>
        <td>
            <input type="text" name="package[<?php echo $package_id; ?>][height]" data-name="height" class="metric form-control" size="5" value="<?php echo $package->height; ?>">
        </td>
        <td>
            <input type="text" name="package[<?php echo $package_id; ?>][weight]" data-name="weight" class="metric form-control" size="5"  value="<?php echo $package->weight; ?>">
        </td>
        <td style="min-width: 100px">
            <button type="button" class="btn-clone-package btn btn-sm btn-default"><i class="fa fa-copy"></i></button>
            <button type="button" class="btn-remove-package btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
        </td>
    </tr>
    <tr>
        <td colspan="7">
            <div class="row">
                <div class="col-sm-2">
                    <input type="text" name="package[<?php echo $package_id; ?>][tracking_number]" placeholder="Tracking #" data-name="tracking_number" class="unique form-control" size="10" value="<?php echo $package->tracking_number; ?>">
                </div>
                <div class="col-sm-2">
                    <input type="text" name="package[<?php echo $package_id; ?>][invoice_number]" placeholder="Invoice #" data-name="invoice_number" class="form-control" size="10" value="<?php echo $package->invoice_number; ?>">
                </div>
                <div class="col-sm-2">
                    <input type="text" name="package[<?php echo $package_id; ?>][invoice_amount]" placeholder="Invoice $" data-name="invoice_amount" class="form-control" size="10" value="<?php echo $package->invoice_amount; ?>">
                </div>
                      <div class="col-sm-6">
                    <textarea name="package[<?php echo $package_id; ?>][description]" data-name="description" placeholder="Description" rows="1" class="form-control"><?php echo $package->description; ?></textarea>
                </div>
            </div>
        </td>
    </tr>
</tbody>
