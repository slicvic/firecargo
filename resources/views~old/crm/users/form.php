<div class="row">
	<div class="col-md-12">
		<h1 class="page-header"><i class="fa fa-user"></i> <?php echo ($user->id ? 'Edit Account # ' . $user->id : 'Create Account'); ?></h1>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<form data-parsley-validate action="/admin/users/<?php echo $user->id ? 'edit/' . $user->id : 'new'; ?>" method="post" id="edit-user-form" class="form-horizontal">
			<div class="flash"></div>
			<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
			<div class="panel panel-default">
  				<div class="panel-heading">Basic Information</div>
  				<div class="panel-body">
	    			<div class="form-group">
						<label class="control-label col-sm-2">Company</label>
						<div class="col-sm-5">
							<input type="text" name="user[company]" placeholder="Company" class="form-control" value="<?php echo $user->company; ?>">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2">First Name</label>
						<div class="col-sm-5">
							<input type="text" name="user[firstname]" placeholder="First Name" class="form-control" value="<?php echo $user->firstname; ?>">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2">Last Name</label>
						<div class="col-sm-5">
							<input type="text" name="user[lastname]" placeholder="Last Name" class="form-control" value="<?php echo $user->lastname; ?>">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2">Email</label>
						<div class="col-sm-5">
							<input type="email" name="user[email]" placeholder="Email" class="form-control" value="<?php echo $user->email; ?>">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2">Password</label>
						<div class="col-sm-5">
							<input type="password" name="user[password]" placeholder="Password" class="form-control" data-parsley-minlength="<?php echo User::PASSWORD_MIN_LENGTH; ?>">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2">Group</label>
						<div class="col-sm-5">
							<?php
								$user_roles = $user->roleArray();
								foreach (Role::all() as $role):
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
							<input type="text" name="user[home_phone]" placeholder="Home Phone" class="phone form-control" value="<?php echo $user->home_phone; ?>">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2">Cell</label>
						<div class="col-sm-2">
							<input type="text" name="user[cell_phone]" placeholder="Cell Phone" class="phone form-control" value="<?php echo $user->cell_phone; ?>">
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
							<input type="text" name="user[address1]" placeholder="Address Line 1" class="form-control" value="<?php echo $user->address1; ?>">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2">Address 2</label>
						<div class="col-sm-5">
							<input type="text" name="user[address2]" placeholder="Address Line 2" placeholder="Company" class="form-control" value="<?php echo $user->address2; ?>">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2">City</label>
						<div class="col-sm-5">
							<input type="text" name="user[city]" placeholder="City" class="form-control" value="<?php echo $user->city; ?>">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2">State</label>
						<div class="col-sm-5">
							<input type="text" name="user[state]" placeholder="State" class="form-control" value="<?php echo $user->state; ?>">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2">Zip</label>
						<div class="col-sm-2">
							<input type="text" name="user[zip]" placeholder="Zip Code" class="form-control" value="<?php echo $user->zip; ?>">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-2">Country</label>
						<div class="col-sm-3">
							<select name="user[country_id]" class="form-control">
								<?php foreach (Country::all() as $country): ?>
									<option value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
				</div>
			</div>
			<button type="submit" class="btn btn-flat success">Save account</button>
        	<a href="/admin/users">Cancel</a>
    	</form>
	</div>
</div>

<script src="/assets/libs/adminlte2/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="/assets/libs/adminlte2/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	//$('.phone').inputmask('(999) 999-9999');
	//$('#dob').inputmask('mm/dd/yyyy', {'placeholder': 'mm/dd/yyyy'});
});
</script>
