<div class="row">
    <div class="col-md-12">
        <h1 class="page-header"><i class="fa fa-cube"></i> <?php echo ($wh->id ? 'Edit Warehouse # ' . $wh->id : 'Create Warehouse'); ?></h1>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <form data-parsley-validate action="/admin/users/" method="post" id="edit-user-form" class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-2">Date</label>
                <div class="col-sm-2">
                    <div class="input-group">
                        <input type="text" name="arrival_date" id="arrival_date" class="form-control" value="<?php echo ($wh->arrival_date ? date('m/d/Y', strtotime($wh->arrival_date)) : date('m/d/Y')); ?>">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="input-group bootstrap-timepicker">
                        <input type="text" id="arrival_time" name="arrival_time" value="<?php echo ($wh->arrival_date ? date('g:i A', strtotime($wh->arrival_date)) : date('g:i A')); ?>" class="form-control">
                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Shipper</label>
                <div class="col-sm-5">
                    <input type="text" id="shipper" class="form-control" value="<?php echo ($wh->shipper ? $wh->shipper->company : NULL); ?>">
                    <input type="hidden" id="shipper_id" name="warehouse[shipper_user_id]" value="<?php echo $wh->shipper_user_id; ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">Consignee</label>
                <div class="col-sm-5">
                    <input type="text" id="consignee" class="form-control" value="<?php echo ($wh->consignee ? $wh->consignee->name() : NULL); ?>">
                    <input type="hidden" id="consignee_id" name="warehouse[consignee_user_id]" value="<?php echo $wh->consignee_user_id; ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">Delivered By</label>
                <div class="col-sm-5">
                    <select name="warehouse[deliverer_id]" class="form-control">
                        <?php foreach(WarehouseDeliverer::all() as $deliverer): ?>
                            <option<?php echo ($wh->deliverer_id == $deliverer->id ? ' selected' : ''); ?> value="<?php echo $deliverer->id; ?>"><?php echo $deliverer->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="/assets/libs/jquery-ui/jquery-ui.min.css">
<script src="/assets/libs/jquery-ui/jquery-ui.min.js"></script>

<link href="/assets/libs/datepicker/css/datepicker.css" rel="stylesheet" type="text/css">
<script src="/assets/libs/datepicker/js/bootstrap-datepicker.js"></script>

<link href="/assets/libs/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css">
<script src="/assets/libs/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>

<script>
$(function() {
    // Datepicker
    $('#arrival_date').datepicker().on('changeDate', function(e){
        $(this).datepicker('hide');
    });

    // Timepicker
    $('#arrival_time').timepicker();
    $('#arrival_time').on('focus', function() {
        return $(this).timepicker('showWidget');
    });

    // Autocomplete
    $('#shipper').autocomplete({
        source: '/admin/warehouses/autocomplete-user',
        minLength: 2,
        select: function(event, ui) {
            $('#shipper').val(ui.item.company);
            $('#shipper_id').val(ui.item.id);
            return false;
        }
    }).autocomplete('instance')._renderItem = function(ul, item) {
        return $('<li>')
            .append('<a>' + item.company + '</a>')
            .appendTo(ul);
    };

    $('#consignee').autocomplete({
        source: '/admin/warehouses/autocomplete-user',
        minLength: 2,
        select: function(event, ui) {
            $('#consignee').val(ui.item.name);
            $('#consignee_id').val(ui.item.id);
            return false;
        }
    }).autocomplete('instance')._renderItem = function(ul, item) {
        return $('<li>')
            .append('<a>' + item.name + '</a>')
            .appendTo(ul);
    };
});
</script>
