@extends('layouts.auth.master')

@section('content')
<div class="ibox-content">
    <h2 class="font-bold">Sign in to your account</h2>
    <div class="row">
        <div class="col-lg-12">
  			<form class="m-t" role="form" action="/login" method="post">
            	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
					<input type="email" name="email" class="form-control" placeholder="Enter your email" value="{{ Input::old('email') }}" required="">
				</div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Enter password" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Sign in</button>
                <a href="/forgot-password">
                    <small>Forgot password?</small>
                </a>
            </form>
        </div>
    </div>
</div>
@stop

