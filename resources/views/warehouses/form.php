<div class="row">
    <h3><i class="fa fa-cube"></i> <?php echo ($warehouse->id) ? 'Edit' : 'Create'; ?> Warehouse</h3>
    <hr>
</div>

<div class="row">
    <div class="col-md-12">
        <form data-parsley-validate action="/warehouses/<?php echo ($warehouse->id) ? 'update/' . $warehouse->id : 'store'; ?>" method="post" id="createWarehouseForm" class="form-horizontal">
           <div class="flashError"></div>
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="warehouse[site_id]" value="<?php echo ($warehouse->id) ? $warehouse->site_id : Auth::user()->site_id; ?>">

            <div class="form-group">
                <label class="control-label col-sm-2">Date</label>
                <div class="col-sm-2">
                    <div class="input-group">
                        <input required type="text" name="warehouse[arrived_at][date]" class="form-control" value="<?php echo ($warehouse->arrived_at) ? date('m/d/Y', strtotime($warehouse->arrived_at)) : date('m/d/Y'); ?>">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="input-group bootstrap-timepicker">
                        <input required type="text" name="warehouse[arrived_at][time]" class="form-control" value="<?php echo ($warehouse->arrived_at) ? date('g:i A', strtotime($warehouse->arrived_at)) : date('g:i A'); ?>">
                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Shipper</label>
                <div class="col-sm-5">
                    <input required type="text" id="shipperName" name="shipper_name" class="form-control" value="<?php echo ($warehouse->shipper) ? $warehouse->shipper->name() : ''; ?>">
                    <input type="hidden" id="shipperId" name="warehouse[shipper_user_id]" value="<?php echo $warehouse->shipper_user_id; ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">Consignee</label>
                <div class="col-sm-5">
                    <input required  type="text" id="consigneeName" name="consignee_name" class="form-control" value="<?php echo ($warehouse->consignee) ? $warehouse->consignee->name() : ''; ?>">
                    <input type="hidden" id="consigneeId" name="warehouse[consignee_user_id]" value="<?php echo $warehouse->consignee_user_id; ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">Delivered By</label>
                <div class="col-sm-5">
                    <select required name="warehouse[delivered_by_courier_id]" class="form-control">
                        <?php foreach(\App\Models\Courier::all() as $courier): ?>
                            <option<?php echo ($warehouse->courier_id == $courier->id) ? ' selected' : ''; ?> value="<?php echo $courier->id; ?>"><?php echo $courier->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <h4>Packages</h4>

            <br>

            <button type="button" class="addRowBtn btn btn-success"><i class="fa fa-plus"></i> Add</button>

            <br><br>

            <table class="table">
                <thead>
                    <tr>
                        <th>Pieces</th>
                        <th>Gross Weight (pounds)</th>
                        <th>Volume (cubic feet)</th>
                        <th>Charge Weight (pounds)</th>
                    </tr>
                </thead>
                <tbody>
                   <tr>
                        <td><span id="totalPieces" style="font-weight: bold;">0</span></td>
                        <td><span id="totalWeight" style="font-weight: bold;">0</span></td>
                        <td><span id="totalVolume" style="font-weight: bold;">0</span></td>
                        <td><span id="totalChargeWeight" style="font-weight: bold;">0</span></td>
                    </tr>
                </tbody>
            </table>

            <?php echo view('warehouses._form_packages', ['packages' => $warehouse->getPackages()]); ?>

            <button type="submit" class="btn btn-flat primary">Save Changes</button>
            <a href="/warehouses">Cancel</a>
        </form>
    </div>
</div>

<link rel="stylesheet" href="/assets/libs/jquery-ui/jquery-ui.min.css">
<script src="/assets/libs/jquery-ui/jquery-ui.min.js"></script>

<script>
$(function() {
    var $trTemplate = $('.packagesTbl > tbody > tr.template').clone();
    $('.packagesTbl > tbody > tr.template').remove();

    updateTotals();

    // Bind clone button
    $('.packagesTbl').on('click', '.cloneRowBtn', function() {
        var rowCount = packageCount();
        var $trClone = $(this).parent().parent().clone();
        $trClone.find('input.unique').val('');

        $trClone.find('input, select').each(function() {
            $(this).attr('name', $(this).attr('name').replace(/\[(-?[-0-9]+)\]/, '[' + (-1*rowCount) + ']'));
        });

        $('.packagesTbl > tbody').append($trClone);
        $('#totalPieces').html(1 + rowCount);

        updateTotals();
    });

    // Bind add button
    $('.addRowBtn').click(function() {
        var rowCount = packageCount();
        var $trNew = $trTemplate.clone();

        $trNew.find('input, select').each(function() {
            $(this).val('');
            $(this).attr('name', $(this).attr('name').replace(/\[(-?[0-9]+)\]/, '[' + (-1*rowCount) + ']'));
        });

        $('.packagesTbl > tbody').append($trNew);
        $('#totalPieces').html(1 + rowCount);

        updateTotals();
    });

    // Bind remove button
    $('.packagesTbl').on('click', '.removeRowBtn', function() {
        $(this).parent().parent().remove();
        updateTotals();
    });

    // Bind field keyup
    $('.packagesTbl').on('keyup', '.metric', function() {
        updateTotals();
    });

    // Bind shipper autocomplete
    $('#shipperName').autocomplete({
        source: '/accounts/autocomplete',
        minLength: 2,
        select: function(event, ui) {
            $('#shipperName').val(ui.item.name);
            $('#shipperId').val(ui.item.id);
            return false;
        }
    }).autocomplete('instance')._renderItem = function(ul, item) {
        return $('<li>')
            .append('<a>' + item.id  + ' - ' + item.name + '</a>')
            .appendTo(ul);
    };

    // Bind consignee autocomplete
    $('#consigneeName').autocomplete({
        source: '/accounts/autocomplete',
        minLength: 2,
        select: function(event, ui) {
            $('#consigneeName').val(ui.item.name);
            $('#consigneeId').val(ui.item.id);
            return false;
        }
    }).autocomplete('instance')._renderItem = function(ul, item) {
        return $('<li>')
            .append('<a>' + item.id  + ' - ' + item.name + '</a>')
            .appendTo(ul);
    };

    function packageCount()
    {
        return $('.packagesTbl > tbody > tr').length;
    }

    function updateTotals()
    {
        var totalWeight = 0;
        var totalVolume = 0;
        var totalChargeWeight = 0;

         $('.packagesTbl > tbody > tr').each(function() {
            var $tr = $(this);

            var length = parseInt($tr.find('input[data-metric="length"]').val()) || 0;
            var width = parseInt($tr.find('input[data-metric="width"]').val()) || 0;
            var height = parseInt($tr.find('input[data-metric="height"]').val()) || 0;
            var weight = parseInt($tr.find('input[data-metric="weight"]').val()) || 0;

            totalWeight += weight;
            totalVolume += (length * width * height);
            totalChargeWeight += weight;
        });

        $('#totalPieces').html(packageCount());
        $('#totalWeight').html(totalWeight);
        $('#totalVolume').html(totalVolume).html();
        $('#totalChargeWeight').html(totalChargeWeight).html();
    }
});
</script>
