@extends('layouts.members.form')

@section('icon', 'user')
@section('title')
    {{ $user->id ? 'Edit' : 'Create' }} Account
@stop

@section('form')
<form data-parsley-validate action="/accounts/{{ ($user->id) ? 'update/' . $user->id : 'store' }}" method="post" class="form-horizontal">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">

	@if (Auth::user()->isAdmin())
		<div class="panel panel-default">
			<div class="panel-heading">Administration</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="control-label col-sm-2">Site</label>
					<div class="col-sm-5">
						<select required class="form-control" name="user[site_id]">
							<option value="">- Choose -</option>
							@foreach (\App\Models\Site::all() as $site)
								<option{{ ($site->id == Input::old('user.site_id', $user->site_id)) ? ' selected' : '' }} value="{{ $site->id }}">{{ $site->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
		</div>
	@endif

	<div class="panel panel-default">
		<div class="panel-heading">Personal Information</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="control-label col-sm-2">Company</label>
				<div class="col-sm-5">
					<input type="text" name="user[company_name]" placeholder="Company Name" class="form-control" value="{{ Input::old('user.company_name', $user->company_name) }}">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2">Name</label>
				<div class="col-sm-5">
					<input type="text" name="user[firstname]" placeholder="First Name" class="form-control" value="{{ Input::old('user.firstname', $user->firstname) }}">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2">Last Name</label>
				<div class="col-sm-5">
					<input type="text" name="user[lastname]" placeholder="Last Name" class="form-control" value="{{ Input::old('user.lastname', $user->lastname) }}">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2">Email</label>
				<div class="col-sm-5">
					<input type="email" name="user[email]" placeholder="Email" class="form-control" value="{{ Input::old('user.email', $user->email) }}">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2">Password</label>
				<div class="col-sm-5">
					<input type="password" name="user[password]" placeholder="Password" class="form-control" data-parsley-minlength="6">
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">ID / RUT<span class="required-field">*</span></label>
				<div class="col-md-6">
					<input type="text" name="user[nin]" class="form-control" value="{{ Input::old('user.nin', $user->nin) }}" required>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2">Group</label>
				<div class="col-sm-5">
					<?php
						$user_roles = $user->rolesArray();
						foreach (\App\Models\Role::all() as $role):
					?>
						<div class="row checkbox">
							<label class="control-label">
								<input {{ isset($user_roles[$role->id]) ? 'checked ' : ''}}type="checkbox" name="roles[]" value="{{ $role->id }}"> {{ ucwords($role->name) }}
							</label>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
			<div class="panel-heading">Shipping Address</div>
			<div class="panel-body">
			<div class="form-group">
				<label class="control-label col-sm-2">Address</label>
				<div class="col-sm-5">
					<input type="text" name="user[address1]" placeholder="Address" class="form-control" value="{{ Input::old('user.address1', $user->address1) }}">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2">Apt / Unit</label>
				<div class="col-sm-5">
					<input type="text" name="user[address2]" placeholder="Apt / Unit" placeholder="Company" class="form-control" value="{{ Input::old('user.address2', $user->address2) }}">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2">City</label>
				<div class="col-sm-5">
					<input type="text" name="user[city]" placeholder="City" class="form-control" value="{{ Input::old('user.city', $user->city) }}">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2">State</label>
				<div class="col-sm-5">
					<input type="text" name="user[state]" placeholder="State" class="form-control" value="{{ Input::old('user.state', $user->state) }}">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2">Postal Code</label>
				<div class="col-sm-2">
					<input type="text" name="user[postal_code]" placeholder="Postal Code" class="form-control" value="{{ Input::old('user.postal_code', $user->postal_code) }}">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2">Country</label>
				<div class="col-sm-3">
					<select name="user[country_id]" class="form-control">
						@foreach (\App\Models\Country::all() as $country)
							<option value="{{ $country->id }}">{{ $country->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2">Home Phone</label>
				<div class="col-sm-2">
					<input type="text" name="user[phone]" placeholder="Home Phone" class="phone form-control" value="{{ Input::old('user.phone', $user->phone) }}">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2">Cell Phone</label>
				<div class="col-sm-2">
					<input type="text" name="user[cellphone]" placeholder="Cell Phone" class="phone form-control" value="{{ Input::old('user.cellphone', $user->cellphone) }}">
				</div>
			</div>
		</div>
	</div>
	<button type="submit" class="btn btn-flat primary">Save Changes</button>
	<a href="/accounts">Cancel</a>
</form>
@stop
