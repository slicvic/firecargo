<div class="row">
    <h3>Update Profile</h3>
    <hr>
</div>

<div class="row">
    <div class="col-md-12">
        <form data-parsley-validate action="/account/profile" method="post" class="form-horizontal">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="user[site_id]" value="<?php echo $user->site_id; ?>">
            <div class="panel panel-default">
                <div class="panel-heading">Personal Information</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label col-sm-2">Company Name</label>
                        <div class="col-sm-5">
                            <input type="text" name="user[company_name]" placeholder="Company Name" class="form-control" value="<?php echo Input::old('user.company_name', $user->company_name); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Name</label>
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
                        <label class="control-label col-sm-2">Home Phone</label>
                        <div class="col-sm-4">
                            <input type="text" name="user[phone]" placeholder="Home Phone" class="form-control" value="<?php echo Input::old('user.phone', $user->phone); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Cell Phone</label>
                        <div class="col-sm-4">
                            <input type="text" name="user[cellphone]" placeholder="Cell Phone" class="form-control" value="<?php echo Input::old('user.cellphone', $user->cellphone); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">ID / RUT</label>
                        <div class="col-md-6">
                            <input type="text" name="user[nin]" class="form-control" value="<?php echo Input::old('user.nin', $user->nin); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Packages</div>
                <div class="panel-body">
                    <div class="form-group">
                            <label class="col-md-2 control-label">Autoroll?</label>
                            <div class="col-md-6">
                                <input type="checkbox" name="user[autoroll_packages]" class="form-control" value="1"<?php echo Input::old('user.autoroll_packages', $user->autoroll_packages) ? ' checked' : ''; ?>>
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
                            <input type="text" name="user[address1]" placeholder="Address" class="form-control" value="<?php echo Input::old('user.address1', $user->address1); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Apt / Unit</label>
                        <div class="col-sm-5">
                            <input type="text" name="user[address2]" placeholder="Apt / Unit" placeholder="Company" class="form-control" value="<?php echo Input::old('user.address2', $user->address2); ?>">
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
                        <label class="control-label col-sm-2">Postal Code</label>
                        <div class="col-sm-3">
                            <input type="text" name="user[postal_code]" placeholder="Postal Code" class="form-control" value="<?php echo Input::old('user.postal_code', $user->postal_code); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Country</label>
                        <div class="col-sm-3">
                            <select name="user[country_id]" class="form-control">
                                <?php foreach (\App\Models\Country::all() as $country): ?>
                                    <option<?php echo ($country->id == $user->country_id) ? ' selected' : ''; ?> value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-flat primary">Save Changes</button>
                    <a href="/account/profile">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
