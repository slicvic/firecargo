<form action="/admin/users/<?php echo $user->id ? 'edit/' . $user->id : 'new'; ?>" method="post" id="edit-user-form" class="form-horizontal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-user"></i> <?php echo ($user->id ? 'Edit Account # ' . $user->id : 'Create Account'); ?></h4>
        <span class="required-field">*</span> Indicates required field
    </div>
    <div class="modal-body">
        <div class="flash"></div>
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <fieldset>
            <div class="form-group">
                <label class="control-label col-sm-2">Company</label>
                <div class="col-sm-8">
                    <input type="text" name="user[company]" class="form-control" value="<?php echo $user->company; ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">First Name<span class="required-field">*</span></label>
                <div class="col-sm-8">
                    <input type="text" name="user[first_name]" class="form-control" value="<?php echo $user->first_name; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">Middle Name</label>
                <div class="col-sm-8">
                    <input type="text" name="user[middle_name]" class="form-control" value="<?php echo $user->middle_name; ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">Last Name<span class="required-field">*</span></label>
                <div class="col-sm-8">
                    <input type="text" name="user[last_name1]" class="form-control" value="<?php echo $user->last_name1; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">Second Last Name</label>
                <div class="col-sm-8">
                    <input type="text" name="user[last_name2]" class="form-control" value="<?php echo $user->last_name2; ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">DOB</label>
                <div class="col-sm-8">
                    <input type="text" id="dob" name="user[dob]" value="<?php echo (!empty($user->dob) ? date('m/d/Y', strtotime($user->dob)) : ''); ?>" class="form-control" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask="">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">Email<span class="required-field">*</span></label>
                <div class="col-sm-8">
                    <input type="email" name="user[email]" class="form-control" value="<?php echo $user->email; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">Password</label>
                <div class="col-sm-8">
                    <input type="password" name="user[password]" class="form-control" data-parsley-minlength="<?php echo User::PASSWORD_MIN_LENGTH; ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">Group</label>
                <div class="col-sm-8">
                    <?php
                        $user_roles = $user->roleArray();
                        foreach (Role::all() as $role):
                    ?>
                        <div class="checkbox">
                            <label class="control-label">
                                <input <?php if (isset($user_roles[$role->id])) echo 'checked '; ?>type="checkbox" name="roles[]" value="<?php echo $role->id; ?>"> <?php echo ucwords($role->name); ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Phone</legend>
            <div class="form-group">
                <label class="control-label col-sm-2">Home</label>
                <div class="col-sm-8">
                    <input type="text" name="user[home_phone]" class="form-control" value="<?php echo $user->home_phone; ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">Mobile</label>
                <div class="col-sm-8">
                    <input type="text" name="user[cell_phone]" class="form-control" value="<?php echo $user->cell_phone; ?>">
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Address</legend>
            <div class="form-group">
                <label class="control-label col-sm-2">Address</label>
                <div class="col-sm-8">
                    <input type="text" name="user[address1]" class="form-control" value="<?php echo $user->address1; ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2"></label>
                <div class="col-sm-8">
                    <input type="text" name="user[address2]" class="form-control" value="<?php echo $user->address2; ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">City</label>
                <div class="col-sm-8">
                    <input type="text" name="user[city]" class="form-control" value="<?php echo $user->city; ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">State</label>
                <div class="col-sm-8">
                    <input type="text" name="user[state]" class="form-control" value="<?php echo $user->state; ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">Zip</label>
                <div class="col-sm-8">
                    <input type="text" name="user[zip]" class="form-control" value="<?php echo $user->zip; ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2">Country</label>
                <div class="col-sm-8">
                    <select name="user[country_id]" class="form-control">
                        <?php foreach (Country::all() as $country): ?>
                            <option value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-info">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    </div>
</form>

<script src="/assets/libs/adminlte2/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="/assets/libs/adminlte2/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
    $('#dob').inputmask('mm/dd/yyyy', {'placeholder': 'mm/dd/yyyy'});
    $('#edit-user-form').parsley();
});
</script>

