@extends('layouts.frontend.master')

@section('content')
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div id="forgot-password-box" class="panel panel-default">
			<div class="panel-heading">
				<h2>Forgot your password?</h2>
			</div>
			<div class="panel-body">
				<form data-parsley-validate action="/forgot-password" method="post" class="form-horizontal">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<p>Enter the email address you registered with and we'll send you password reset instructions.</p>
					<div class="form-group">
						<div id="error-container3" class="col-sm-12">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-user"></i></div>
								<input type="email" name="email" class="form-control input-lg" placeholder="Your email address" data-parsley-errors-container="#error-container3" required>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12 text-right">
							<button type="submit" class="btn btn-lg btn-success">Send</button>
							<a id="show-login-box" href="/login">Log In</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@stop
