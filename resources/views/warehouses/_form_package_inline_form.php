<?php $package_id = ($package->id) ? $package->id : 0; ?>
<tr>
    <td>
        <button type="button" class="cloneRowBtn btn btn-default">Clone</button>
        <button type="button" class="removeRowBtn btn btn-danger "><i class="fa fa-times"></i></button>
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
    <td>
        <input type="text" name="package[<?php echo $package_id; ?>][description]" data-name="description" class="form-control" size="5" value="<?php echo $package->description; ?>">
    </td>
    <td>
        <input type="text" name="package[<?php echo $package_id; ?>][invoice_number]" data-name="invoice_number" class="form-control" size="5" value="<?php echo $package->invoice_number; ?>">
    </td>
    <td>
        <input type="text" name="package[<?php echo $package_id; ?>][invoice_amount]" data-name="invoice_amount" class="form-control" size="5" value="<?php echo $package->invoice_amount; ?>">
    </td>
    <td>
        <input type="text" name="package[<?php echo $package_id; ?>][tracking_number]" data-name="tracking_number" class="unique form-control" size="5" value="<?php echo $package->tracking_number; ?>">
    </td>
</tr>
