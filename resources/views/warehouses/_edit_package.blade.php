<div class="panel package{{ $package->exists ? ' panel-info panel-info-light' : ' new hidden package-template panel-warning panel-warning-light' }}">
    <div class="panel-heading clear">
        <h3 class="pull-left panel-title">
            #
            @if ($package->exists)
                {{ $package->id  }}
            @else
                New Piece
            @endif
        </h3>
        <div class="pull-right">
            <button type="button" class="clone-package-btn btn btn-sm btn-white"><i class="fa fa-copy"></i> Duplicate</button>
            @if ($package->exists)
                <label>
                    <input type="checkbox" value="1" class="icheck-red delete-package-icheck" name="packages[{{ $package->id }}][delete]">
                    Delete
                </label>
            @else
                <button type="button" class="remove-package-btn btn btn-sm btn-danger"><i class="fa fa-times"></i> Remove</button>
            @endif
        </div>
    </div>
    <div class="panel-body">

        <div class="row">
            <div class="col-md-4">
                <label>US Tracking #</label>
                <input type="text" name="packages[{{ $package->id }}][tracking_number]" data-name="tracking_number" data-unique="true" class="form-control" value="{{ $package->tracking_number }}">
            </div>
            <div class="col-md-2">
                <label>Type</label>
                <select name="packages[{{ $package->id }}][type_id]" data-name="type_id" class="form-control">
                    @foreach($packageTypes as $type)
                        <option value="{{ $type->id }}"{{ ($type->id == $package->type_id) ? ' selected' : '' }}>{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        <label>Weight <i class="fa fa-balance-scale"></i></label>
                        <input type="text" name="packages[{{ $package->id }}][weight]" data-name="weight" class="metric form-control" value="{{ $package->weight }}">
                    </div>
                    <div class="col-sm-3">
                        <label>Length</label>
                        <input type="text" name="packages[{{ $package->id }}][length]" data-name="length" class="metric form-control" value="{{ $package->length }}">
                    </div>
                    <div class="col-sm-3">
                        <label>Width</label>
                        <input type="text" name="packages[{{ $package->id }}][width]" data-name="width" class="metric form-control" value="{{ $package->width }}">
                    </div>
                    <div class="col-sm-3">
                        <label>Height</label>
                        <input type="text" name="packages[{{ $package->id }}][height]" data-name="height" class="metric form-control" value="{{ $package->height }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <label class="control-label">National Tracking #</label>
                <input type="text" name="packages[{{ $package->id }}][invoice_number]" data-name="invoice_number" data-unique="true" class="form-control" value="{{ $package->invoice_number }}">
            </div>
            <div class="col-sm-2">
                <label class="control-label">Invoice #</label>
                <input type="text" name="packages[{{ $package->id }}][invoice_number]" data-name="invoice_number" class="form-control" value="{{ $package->invoice_number }}">
            </div>
            <div class="col-sm-2">
                <label class="control-label">Invoice $</label>
                <input type="text" name="packages[{{ $package->id }}][invoice_value]" data-name="invoice_value" class="form-control" value="{{ str_replace('$', '', $package->present()->invoiceValue()) }}">
            </div>
            <div class="col-sm-4">
                <label class="control-label">Description</label>
                <input name="packages[{{ $package->id }}][description]" data-name="description" data-unique="true" class="form-control" value="{{ $package->description }}">
            </div>
        </div>
    </div>
    @if ($package->exists)
        <div class="panel-footer text-right">
            <small>Created: {{ $package->present()->createdAt() }}</small>
            @if ($updatedAt = $package->present()->updatedAt(NULL))
                <small>Updated: {{ $updatedAt }}</small>
            @endif
        </div>
    @endif
</div>
