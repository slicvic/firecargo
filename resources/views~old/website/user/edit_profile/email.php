<form data-parsley-validate id="change-email-form" class="form-horizontal">
	<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
	<div class="form-group">
		<label class="col-md-2 control-label"><?php echo Lang::get('messages.email2'); ?></label>  
		<div class="col-md-5">
			<i><?php echo Auth::user()->email; ?></i>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label"><?php echo Lang::get('messages.new_email'); ?></label>  
		<div class="col-md-5">
			<input type="email" name="email" class="form-control" required>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label"><?php echo Lang::get('messages.current_password'); ?></label>  
		<div class="col-md-5">
			<input type="password" name="current_password" class="form-control" required>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label"></label>  
		<div class="col-md-5">
			<button type="submit" class="btn btn-lg btn-success"><?php echo Lang::get('messages.change_email'); ?></button>
		</div>
	</div>
</form>