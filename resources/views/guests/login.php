<div class="row">
	<div class="col-md-6 col-md-offset-3">

		<!--Login Box -->
		<div id="login-box" class="panel panel-primary">
			<div class="panel-heading">
				<h1><?php echo trans('messages.login'); ?></h1>
			</div>
			<div class="panel-body">
				<form data-parsley-validate action="/login" method="post" class="form-horizontal">
					<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
					<div class="form-group">
						<div id="error-container1" class="col-sm-12">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-user"></i></div>
								<input type="text" name="username" class="form-control input-lg" placeholder="<?php echo trans('messages.email_or_tracking_code'); ?>" value="<?php echo Input::old('username'); ?>" data-parsley-errors-container="#error-container1" required>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div id="error-container2" class="col-sm-12">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-lock"></i></div>
								<input type="password" name="password" class="form-control input-lg" placeholder="<?php echo trans('messages.password'); ?>" data-parsley-errors-container="#error-container2" required>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12 text-right">
							<button type="submit" class="btn btn-lg btn-success"><?php echo trans('messages.enter'); ?></button>
							<a id="show-forgot-password-box" href="/forgot-password"><?php echo trans('messages.forgot_password'); ?></a>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- /Login Box -->

		<!-- Forgot Password Box -->
		<!-- /Forgot Password Box -->

	</div>
</div>
