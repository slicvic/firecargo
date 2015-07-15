<tbody class="{!! $package->exists ? 'package' : 'hidden package-template' !!}">
    <tr>
        <td><button type="button" class="btn-toggle-detail btn btn-link btn-sm"><i class="fa fa-plus"></i></button></td>
        <td><span class="label label-{{ $package->exists ? 'success' : 'danger' }}">{{ $package->exists ? $package->id : 'NEW' }}</span></td>
        <td>
            <select name="packages[{{ $package->id }}][status_id]" data-name="status_id" class="form-control">
                @foreach($packageStatuses as $status)
                    <option{{ ($status->id == $package->status_id) ? ' selected' : '' }} value="{{ $status->id }}">{{ $status->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select name="packages[{{ $package->id }}][type_id]" data-name="type_id" class="form-control">
                @foreach($packageTypes as $type)
                    <option{{ ($type->id == $package->type_id) ? ' selected' : '' }} value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="text" name="packages[{{ $package->id }}][length]" data-name="length" class="metric form-control" size="5" value="{{ $package->length }}">
        </td>
        <td>
            <input type="text" name="packages[{{ $package->id }}][width]" data-name="width" class="metric form-control" size="5" value="{{ $package->width }}">
        </td>
        <td>
            <input type="text" name="packages[{{ $package->id }}][height]" data-name="height" class="metric form-control" size="5" value="{{ $package->height }}">
        </td>
        <td>
            <input type="text" name="packages[{{ $package->id }}][weight]" data-name="weight" class="metric form-control" size="5"  value="{{ $package->weight }}">
        </td>
        <td>
            <div class="btn-group">
                <button type="button" class="btn-clone-package btn btn-sm btn-white">Clone</button>
                @if ( ! $package->exists)
                    <button type="button" class="btn-remove-package btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
                @endif
            </div>
        </td>
    </tr>
    <tr class="package-detail hidden">
        <td colspan="9">
            <div class="row">
                <div class="form-group">
                    <label class="control-label col-sm-2">Tracking #</label>
                    <div class="col-sm-4">
                        <input type="text" name="packages[{{ $package->id }}][tracking_number]" data-name="tracking_number" class="unique form-control" value="{{ $package->tracking_number }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Invoice #</label>
                    <div class="col-sm-4">
                        <input type="text" name="packages[{{ $package->id }}][invoice_number]" data-name="invoice_number" class="form-control" value="{{ $package->invoice_number }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Invoice $</label>
                    <div class="col-sm-2">
                        <input type="text" name="packages[{{ $package->id }}][invoice_amount]" data-name="invoice_amount" class="form-control" value="{{ $package->present()->invoiceAmount(FALSE) }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Description</label>
                    <div class="col-sm-4">
                        <textarea name="packages[{{ $package->id }}][description]" data-name="description" rows="4" class="unique form-control">{{ $package->description }}</textarea>
                    </div>
                </div>
            </div>
        </td>
    </tr>
</tbody>
