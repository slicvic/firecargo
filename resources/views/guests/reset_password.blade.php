@extends('layouts.guests')

@section('content')
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h1>Reset your password</h1>
			</div>
			<div class="panel-body">
				<form data-parsley-validate id="reset-password-form" action="{{ Request::fullUrl() }}" method="post" class="form-horizontal">
					<div class="flash"></div>
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-group">
						<div id="error-container1" class="col-sm-12">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-lock"></i></div>
								<input id="password" type="password" name="password" class="form-control input-lg" placeholder="New password" data-parsley-errors-container="#error-container1" data-parsley-minlength="6" required>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div id="error-container2" class="col-sm-12">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-lock"></i></div>
								<input type="password" class="form-control input-lg" placeholder="Confirm new password" data-parsley-equalto="#password" data-parsley-errors-container="#error-container2" required>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12 text-right">
							<button type="submit" class="btn btn-lg btn-success">Change</button>
							<a href="/login">Log In</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@stop
