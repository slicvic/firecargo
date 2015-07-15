@extends('layouts.auth.master')

@section('content')
<div class="ibox-content">
    <h2 class="font-bold">Reset your password</h2>
    <p>New passwords must be a mininum of 8 characters in length.</p>
	<div class="row">
	    <div class="col-lg-12">
        	<form action="{{ Request::fullUrl() }}" method="post" class="m-t">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
					<input type="password" id="password" name="password" class="form-control input-lg" placeholder="New password" minlength="8" required>
				</div>
                <div class="form-group">
                    <input type="password" name="confirm_password" class="form-control input-lg" placeholder="Confirm new password" equalto="#password" required>
                </div>
				<button type="submit" class="btn btn-primary block full-width m-b">Reset password</button>
				<a href="/login">
                    <small>Sign in to your account</small>
                </a>
			</form>
		</div>
	</div>
</div>
@stop

