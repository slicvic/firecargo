@extends('site.layouts.narrow')

@section('narrow_content')
<div class="ibox-content">
    <h2 class="font-bold">Forgot password</h2>
    <p>Enter the email address you registered with and your password will be reset and emailed to you.</p>
	<div class="row">
	    <div class="col-md-12">
        	<form action="/forgot-password" method="post" class="m-t">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-group">
					<input type="email" name="email" class="form-control input-lg" placeholder="Your email address" value="{{ Input::old('email') }}" required>
				</div>
				<button type="submit" class="btn btn-primary block full-width m-b">Send new password</button>
				<a href="/login{{ $queryString }}">
                    <small>Sign in to your account</small>
                </a>
			</form>
		</div>
	</div>
</div>
@stop
