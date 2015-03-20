<form data-parsley-validate id="change-password-form" class="form-horizontal">
	<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
	<div class="form-group">
		<label class="col-md-2 control-label"><?php echo Lang::get('messages.current_password'); ?></label>  
		<div class="col-md-5">
			<input type="password" name="current_password" class="form-control" required>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label"><?php echo Lang::get('messages.new_password'); ?></label>  
		<div class="col-md-5">
			<input id="new-password" type="password" name="new_password" class="form-control" data-parsley-minlength="<?php echo User::PASSWORD_MIN_LENGTH; ?>" required>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label"><?php echo Lang::get('messages.new_password_confirm'); ?></label>  
		<div class="col-md-5">
			<input type="password" name="new_password_confirm" class="form-control" data-parsley-equalto="#new-password" required>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label"></label>  
		<div class="col-md-5">
			<button type="submit" class="btn btn-lg btn-success"><?php echo Lang::get('messages.change_password2'); ?></button>
		</div>
	</div>
</form>