
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h1><?php echo trans('messages.change_password'); ?></h1>
			</div>
			<div class="panel-body">
				<form data-parsley-validate id="reset-password-form" action="<?php echo Request::fullUrl(); ?>" method="post" class="form-horizontal">
					<div class="flash"></div>
					<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
					<div class="form-group">
						<div id="error-container1" class="col-sm-12">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-lock"></i></div>
								<input id="password" type="password" name="password" class="form-control input-lg" placeholder="<?php echo trans('messages.new_password'); ?>" data-parsley-errors-container="#error-container1" data-parsley-minlength="6" required>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div id="error-container2" class="col-sm-12">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-lock"></i></div>
								<input type="password" class="form-control input-lg" placeholder="<?php echo trans('messages.new_password_confirm'); ?>" data-parsley-equalto="#password" data-parsley-errors-container="#error-container2" required>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12 text-right">
							<button type="submit" class="btn btn-lg btn-success"><?php echo trans('messages.change_password2'); ?></button>
							<a href="/login"><?php echo Lang::get('messages.login'); ?></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
