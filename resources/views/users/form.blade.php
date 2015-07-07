<?php $shippingAddress = $user->shippingAddress ?: new App\Models\Address; ?>

@extends('layouts.admin.model.form')

@section('icon', 'user')

@section('title')
    {{ $user->id ? 'Editing Account # ' . $user->id : 'Create Account' }}
@stop

@section('subtitle')
    <ol class="breadcrumb">
        <li>
            <a href="/users">Users</a>
        </li>
        <li class="active">
            <strong>{{ $user->id ? 'Edit' : 'Create' }}</strong>
        </li>
    </ol>
@stop

@section('form')
	<form action="/accounts/{{ ($user->id) ? 'update/' . $user->id : 'store' }}" method="post" class="form-horizontal" data-parsley-validate>
		<input type="hidden" name="_token" value="{{ csrf_token() }}">

		<div class="row">
			<div class="col-lg-12">
				<div class="tabs-container">
					<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true"> Account Info</a></li>
					<li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false"> Contact Info</a></li>
					<li class=""><a data-toggle="tab" href="#tab-3" aria-expanded="false"> Address</a></li>
					</ul>
					<div class="tab-content">
						<div id="tab-1" class="tab-pane active">
							<div class="panel-body">

								@if (Auth::user()->isAdmin())
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
								@endif

								<div class="form-group">
									<label class="control-label col-sm-2">Company</label>
									<div class="col-sm-5">
										<input type="text" name="user[business_name]" placeholder="Company" class="form-control" value="{{ Input::old('user.business_name', $user->business_name) }}">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2">First Name</label>
									<div class="col-sm-5">
										<input type="text" name="user[first_name]" placeholder="First Name" class="form-control" value="{{ Input::old('user.first_name', $user->first_name) }}">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2">Last Name</label>
									<div class="col-sm-5">
										<input type="text" name="user[last_name]" placeholder="Last Name" class="form-control" value="{{ Input::old('user.last_name', $user->last_name) }}">
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
									<label class="control-label col-sm-2">Group</label>
									<div class="col-sm-5">
										<?php
											$userRoles = $user->present()->rolesAsArray();
											foreach (\App\Models\Role::all() as $role):
										?>
											<div class="row checkbox">
												<label class="control-label">
													<input {{ isset($userRoles[$role->id]) ? 'checked ' : ''}}type="checkbox" name="roles[]" value="{{ $role->id }}"> {{ ucwords($role->name) }}
												</label>
											</div>
										<?php endforeach; ?>
									</div>
								</div>
							</div>
						</div>
						<div id="tab-2" class="tab-pane">
							<div class="panel-body">
								<div class="form-group">
									<label class="control-label col-sm-2">Phone</label>
									<div class="col-sm-2">
										<input type="text" name="user[phone]" placeholder="Phone" class="phone form-control" value="{{ Input::old('user.phone', $user->phone) }}">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2">Mobile Phone</label>
									<div class="col-sm-2">
										<input type="text" name="user[mobile_phone]" placeholder="Mobile Phone" class="phone form-control" value="{{ Input::old('user.mobile_phone', $user->mobile_phone) }}">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2">Fax</label>
									<div class="col-sm-2">
										<input type="text" name="user[fax]" placeholder="Fax" class="phone form-control" value="{{ Input::old('user.fax', $user->fax) }}">
									</div>
								</div>
							</div>
						</div>
						<div id="tab-3" class="tab-pane">
							<div class="panel-body">
								<div class="form-group">
									<label class="control-label col-sm-2">Address 1</label>
									<div class="col-sm-5">
										<input type="text" name="shipping_address[address1]" placeholder="Address 1" class="form-control" value="{{ Input::old('shipping_address.address1', $shippingAddress->address1) }}">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2">Address 2</label>
									<div class="col-sm-5">
										<input type="text" name="shipping_address[address2]" placeholder="Address 2" placeholder="Company" class="form-control" value="{{ Input::old('shipping_address.address2', $shippingAddress->address2) }}">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2">City</label>
									<div class="col-sm-5">
										<input type="text" name="shipping_address[city]" placeholder="City" class="form-control" value="{{ Input::old('shipping_address.city', $shippingAddress->city) }}">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2">State</label>
									<div class="col-sm-5">
										<input type="text" name="shipping_address[state]" placeholder="State" class="form-control" value="{{ Input::old('shipping_address.state', $shippingAddress->state) }}">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2">Postal Code</label>
									<div class="col-sm-2">
										<input type="text" name="shipping_address[postal_code]" placeholder="Postal Code" class="form-control" value="{{ Input::old('shipping_address.postal_code', $shippingAddress->postal_code) }}">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2">Country</label>
									<div class="col-sm-3">
										<select name="shipping_address[country_id]" class="form-control">
											@foreach (\App\Models\Country::all() as $country)
												<option{{ ($country->id == Input::old('shipping_address.country_id', $shippingAddress->country_id)) ? ' selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<br>

		<div class="form-group">
		    <div class="col-sm-12">
		        <a class="btn btn-white" href="/accounts">Cancel</a>
		        <button class="btn btn-primary" type="submit">Save changes</button>
		    </div>
		</div>
	</form>
@stop
