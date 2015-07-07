<?php $packageId = ($package->id) ? $package->id : 0; ?>
<tbody{!! ($packageId) ? 'class="package"' : ' style="display:none;" class="package-template"' !!}>
    <tr>
        <td>
            <select name="package[{{ $packageId }}][status_id]" data-name="status_id" class="form-control">
                @foreach(\App\Models\PackageStatus::allByCurrentCompany('is_default', 'desc') as $status)
                    <option{{ ($package->status_id == $status->id) ? ' selected' : '' }} value="{{ $status->id }}">{{ $status->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select name="package[{{ $packageId }}][type_id]" data-name="type_id" class="form-control">
                @foreach(\App\Models\PackageType::allByCurrentCompany() as $type)
                    <option{{ ($package->type_id == $type->id) ? ' selected' : '' }} value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="text" name="package[{{ $packageId }}][length]" data-name="length" class="metric form-control" size="5" value="{{ $package->length }}">
        </td>
        <td>
            <input type="text" name="package[{{ $packageId }}][width]" data-name="width" class="metric form-control" size="5" value="{{ $package->width }}">
        </td>
        <td>
            <input type="text" name="package[{{ $packageId }}][height]" data-name="height" class="metric form-control" size="5" value="{{ $package->height }}">
        </td>
        <td>
            <input type="text" name="package[{{ $packageId }}][weight]" data-name="weight" class="metric form-control" size="5"  value="{{ $package->weight }}">
        </td>
        <td style="min-width: 100px">
            <div class="btn-group">
                <button type="button" class="btn-clone-package btn btn-sm btn-white">Clone</button>
                <button type="button" class="btn-remove-package btn btn-sm btn-danger">Remove</button>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="7">
            <div class="row">
                <div class="col-sm-2">
                    <input type="text" name="package[{{ $packageId }}][tracking_number]" placeholder="Tracking #" data-name="tracking_number" class="unique form-control" size="10" value="{{ $package->tracking_number }}">
                </div>
                <div class="col-sm-2">
                    <input type="text" name="package[{{ $packageId }}][invoice_number]" placeholder="Invoice #" data-name="invoice_number" class="form-control" size="10" value="{{ $package->invoice_number }}">
                </div>
                <div class="col-sm-2">
                    <input type="text" name="package[{{ $packageId }}][invoice_amount]" placeholder="Invoice $USD" data-name="invoice_amount" class="form-control" size="10" value="{{ $package->invoice_amount }}">
                </div>
                      <div class="col-sm-6">
                    <textarea name="package[{{ $packageId }}][description]" data-name="description" placeholder="Description" rows="1" class="form-control">{{ $package->description }}</textarea>
                </div>
            </div>
        </td>
    </tr>
</tbody>
