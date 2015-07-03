@extends('layouts.frontend.master')

@section('content')
<div class="row">
	<div class="col-md-6 col-md-offset-3">

		<!--Login Box -->
		<div id="login-box" class="panel panel-default">
			<div class="panel-heading">
				<h1>Log In</h1>
			</div>
			<div class="panel-body">
				<form data-parsley-validate action="/login" method="post" class="form-horizontal">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-group">
						<div id="error-container1" class="col-sm-12">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-user"></i></div>
								<input type="text" name="username" class="form-control input-lg" placeholder="Your email address" value="{{ Input::old('username') }}" data-parsley-errors-container="#error-container1" required>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div id="error-container2" class="col-sm-12">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-lock"></i></div>
								<input type="password" name="password" class="form-control input-lg" placeholder="Your password" data-parsley-errors-container="#error-container2" required>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12 text-right">
							<button type="submit" class="btn btn-lg btn-success">Log In</button>
							<a id="show-forgot-password-box" href="/forgot-password">Forgot your password?</a>
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
@stop
