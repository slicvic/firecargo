<div class="row">
    <h3><i class="fa fa-user"></i> <?php echo ($user->id) ? 'Edit' : 'Create'; ?> Account</h3>
    <hr>
</div>

<div class="row">
	<div class="col-md-12">
		<form data-parsley-validate action="/accounts/<?php echo ($user->id) ? 'update/' . $user->id : 'store'; ?>" method="post" class="form-horizontal">
			<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

			<?php if (Auth::user()->isAdmin()): ?>
				<div class="panel panel-default">
	  				<div class="panel-heading">Master</div>
	  				<div class="panel-body">
		    			<div class="form-group">
	  						<label class="control-label col-sm-2">Company</label>
							<div class="col-sm-5">
								<select required class="form-control" name="user[company_id]">
									<option value="">- Choose -</option>
									<?php foreach(\App\Models\Company::all() as $company): ?>
										<option<?php echo ($company->id == Input::old('user.company_id', $user->company_id)) ? ' selected' : ''; ?> value="<?php echo $company->id; ?>"><?php echo $company->name . ' (' . $company->code . ')'; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
	  				</div>
	  			</div>
  			<?php endif; ?>

			<div class="panel panel-default">
  				<div class="panel-heading">Basic Information</div>
  				<div class="panel-body">
	    			<div class="form-group">
						<label class="control-label col-sm-2">Company Name</label>
						<div class="col-sm-5">
							<input type="text" name="user[company_name]" placeholder="Company Name" class="form-control" value="<?php echo Input::old('user.company_name', $user->company_name); ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">First Name</label>
						<div class="col-sm-5">
							<input type="text" name="user[firstname]" placeholder="First Name" class="form-control" value="<?php echo Input::old('user.firstname', $user->firstname); ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Last Name</label>
						<div class="col-sm-5">
							<input type="text" name="user[lastname]" placeholder="Last Name" class="form-control" value="<?php echo Input::old('user.lastname', $user->lastname); ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Email</label>
						<div class="col-sm-5">
							<input type="email" name="user[email]" placeholder="Email" class="form-control" value="<?php echo Input::old('user.email', $user->email); ?>">
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
								$user_roles = $user->rolesArray();
								foreach (\App\Models\Role::all() as $role):
							?>
								<div class="row checkbox">
									<label class="control-label">
										<input <?php if (isset($user_roles[$role->id])) echo 'checked '; ?>type="checkbox" name="roles[]" value="<?php echo $role->id; ?>"> <?php echo ucwords($role->name); ?>
									</label>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
  				</div>
			</div>

			<div class="panel panel-default">
  				<div class="panel-heading">Phone</div>
  				<div class="panel-body">
					<div class="form-group">
						<label class="control-label col-sm-2">Home</label>
						<div class="col-sm-2">
							<input type="text" name="user[home_phone]" placeholder="Home Phone" class="phone form-control" value="<?php echo Input::old('user.home_phone', $user->home_phone); ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Cell</label>
						<div class="col-sm-2">
							<input type="text" name="user[cell_phone]" placeholder="Cell Phone" class="phone form-control" value="<?php echo Input::old('user.cell_phone', $user->cell_phone); ?>">
						</div>
					</div>
				</div>
			</div>

			<div class="panel panel-default">
  				<div class="panel-heading">Address</div>
  				<div class="panel-body">
					<div class="form-group">
						<label class="control-label col-sm-2">Address 1</label>
						<div class="col-sm-5">
							<input type="text" name="user[address1]" placeholder="Address Line 1" class="form-control" value="<?php echo Input::old('user.address1', $user->address1); ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Address 2</label>
						<div class="col-sm-5">
							<input type="text" name="user[address2]" placeholder="Address Line 2" placeholder="Company" class="form-control" value="<?php echo Input::old('user.address2', $user->address2); ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">City</label>
						<div class="col-sm-5">
							<input type="text" name="user[city]" placeholder="City" class="form-control" value="<?php echo Input::old('user.city', $user->city); ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">State</label>
						<div class="col-sm-5">
							<input type="text" name="user[state]" placeholder="State" class="form-control" value="<?php echo Input::old('user.state', $user->state); ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Zip</label>
						<div class="col-sm-2">
							<input type="text" name="user[zip]" placeholder="Zip Code" class="form-control" value="<?php echo Input::old('user.zip', $user->zip); ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2">Country</label>
						<div class="col-sm-3">
							<select name="user[country_id]" class="form-control">
								<?php foreach (\App\Models\Country::all() as $country): ?>
									<option value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>
			</div>
			<button type="submit" class="btn btn-flat primary">Save Changes</button>
        	<a href="/accounts">Cancel</a>
    	</form>
	</div>
</div>
