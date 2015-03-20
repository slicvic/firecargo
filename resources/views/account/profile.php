<div class="row">
    <h3>Update Profile</h3>
    <hr>
</div>

<div class="row">
    <div class="col-md-12">
        <form data-parsley-validate action="/account/profile" method="post" class="form-horizontal">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
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
            <div class="form-group">
                <div class="col-md-offset-2 col-md-8">
                    <button type="submit" class="btn btn-flat primary">Save Changes</button>
                    <a href="/account/dashboard">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
