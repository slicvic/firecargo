<div class="row">
    <h3><i class="fa fa-cube"></i> <?php echo ($warehouse->id) ? 'Edit' : 'Create'; ?> Warehouse</h3>
    <hr>
</div>

<div class="row">
    <div class="col-md-12">
        <form data-parsley-validate action="/ware/" method="post" class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-2">Date</label>
                <div class="col-sm-2">
                    <div class="input-group">
                        <input type="text" name="arrival_date" id="arrival_date" class="form-control" value="<?php echo ($warehouse->arrival_date ? date('m/d/Y', strtotime($warehouse->arrival_date)) : date('m/d/Y')); ?>">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="input-group bootstrap-timepicker">
                        <input type="text" id="arrival_time" name="arrival_time" value="<?php echo ($warehouse->arrival_date) ? date('g:i A', strtotime($warehouse->arrival_date)) : date('g:i A'); ?>" class="form-control">
                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Shipper</label>
                <div class="col-sm-5">
                    <input type="text" id="shipper" class="form-control" value="<?php echo ($warehouse->shipper) ? $warehouse->shipper->company : NULL; ?>">
                    <input type="hidden" id="shipper_id" name="warehouse[shipper_user_id]" value="<?php echo $warehouse->shipper_user_id; ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">Consignee</label>
                <div class="col-sm-5">
                    <input type="text" id="consignee" class="form-control" value="<?php echo ($warehouse->consignee) ? $warehouse->consignee->name() : NULL; ?>">
                    <input type="hidden" id="consignee_id" name="warehouse[consignee_user_id]" value="<?php echo $warehouse->consignee_user_id; ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">Delivered By</label>
                <div class="col-sm-5">
                    <select name="warehouse[carrier_id]" class="form-control">
                        <?php foreach(\App\Models\ShippingCarrier::all() as $carrier): ?>
                            <option<?php echo ($warehouse->carrier_id == $carrier->id ? ' selected' : ''); ?> value="<?php echo $carrier->id; ?>"><?php echo $carrier->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="/assets/libs/jquery-ui/jquery-ui.min.css">
<script src="/assets/libs/jquery-ui/jquery-ui.min.js"></script>



<script>
$(function() {
    // Datepicker
    /*
    $('#arrival_date').datepicker().on('changeDate', function(e){
        $(this).datepicker('hide');
    });

    // Timepicker
    $('#arrival_time').timepicker();
    $('#arrival_time').on('focus', function() {
        return $(this).timepicker('showWidget');
    });
    */

    // Autocomplete
    $('#shipper').autocomplete({
        source: '/warehouses/autocomplete-user',
        minLength: 2,
        select: function(event, ui) {
            $('#shipper').val(ui.item.company);
            $('#shipper_id').val(ui.item.id);
            return false;
        }
    }).autocomplete('instance')._renderItem = function(ul, item) {
        return $('<li>')
            .append('<a>' + item.id  + ' - ' + item.company + '</a>')
            .appendTo(ul);
    };

    $('#consignee').autocomplete({
        source: '/warehouses/autocomplete-user',
        minLength: 2,
        select: function(event, ui) {
            $('#consignee').val(ui.item.name);
            $('#consignee_id').val(ui.item.id);
            return false;
        }
    }).autocomplete('instance')._renderItem = function(ul, item) {
        return $('<li>')
            .append('<a>' + item.id  + ' - ' + item.name + '</a>')
            .appendTo(ul);
    };
});
</script>
