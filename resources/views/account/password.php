<div class="row">
    <h3>Update Profile</h3>
    <hr>
</div>

<form data-parsley-validate action="/account/password" method="post" class="form-horizontal">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    <div class="form-group">
        <label class="col-md-2 control-label"><?php echo trans('messages.current_password'); ?></label>
        <div class="col-md-5">
            <input type="password" name="current" class="form-control" required>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label"><?php echo trans('messages.new_password'); ?></label>
        <div class="col-md-5">
            <input id="new" type="password" name="new" class="form-control" data-parsley-minlength="6" required>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label"><?php echo trans('messages.new_password_confirm'); ?></label>
        <div class="col-md-5">
            <input type="password" name="confirm" class="form-control" data-parsley-equalto="#new" required>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-8">
            <button type="submit" class="btn btn-flat primary"><?php echo trans('messages.change_password2'); ?></button>
        </div>
    </div>
</form>
