<?php $id = ($package->exists) ? $package->id : 0; ?>
<tbody{!! $id ? 'class="package"' : ' style="display:none;" class="package-template"' !!}>
    <tr>
        <td class="id">{{ $id ?: 'NEW' }}</td>
        <td>
            <select name="packages[{{ $id }}][status_id]" data-name="status_id" class="form-control">
                @foreach(\App\Models\PackageStatus::allByCurrentUserCompanyId('is_default', 'desc') as $status)
                    <option{{ ($status->id == $package->status_id) ? ' selected' : '' }} value="{{ $status->id }}">{{ $status->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select name="packages[{{ $id }}][type_id]" data-name="type_id" class="form-control">
                @foreach(\App\Models\PackageType::all() as $type)
                    <option{{ ($type->id == $package->type_id) ? ' selected' : '' }} value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="text" name="packages[{{ $id }}][length]" data-name="length" class="metric form-control" size="5" value="{{ $package->length }}">
        </td>
        <td>
            <input type="text" name="packages[{{ $id }}][width]" data-name="width" class="metric form-control" size="5" value="{{ $package->width }}">
        </td>
        <td>
            <input type="text" name="packages[{{ $id }}][height]" data-name="height" class="metric form-control" size="5" value="{{ $package->height }}">
        </td>
        <td>
            <input type="text" name="packages[{{ $id }}][weight]" data-name="weight" class="metric form-control" size="5"  value="{{ $package->weight }}">
        </td>
        <td style="min-width: 100px">
            <div class="btn-group">
                <button type="button" class="btn-clone-package btn btn-sm btn-white">Clone</button>
                <button type="button" class="btn-remove-package btn btn-sm btn-danger">Remove</button>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="8">
            <div class="row">
                <div class="col-sm-2">
                    <input type="text" name="packages[{{ $id }}][tracking_number]" placeholder="Tracking #" data-name="tracking_number" class="unique form-control" size="10" value="{{ $package->tracking_number }}">
                </div>
                <div class="col-sm-2">
                    <input type="text" name="packages[{{ $id }}][invoice_number]" placeholder="Invoice #" data-name="invoice_number" class="form-control" size="10" value="{{ $package->invoice_number }}">
                </div>
                <div class="col-sm-2">
                    <input type="text" name="packages[{{ $id }}][invoice_amount]" placeholder="Invoice $USD" data-name="invoice_amount" class="form-control" size="10" value="{{ $package->invoice_amount }}">
                </div>
                <div class="col-sm-6">
                    <textarea name="packages[{{ $id }}][description]" data-name="description" placeholder="Description" rows="1" class="unique form-control">{{ $package->description }}</textarea>
                </div>
            </div>
        </td>
    </tr>
</tbody>
