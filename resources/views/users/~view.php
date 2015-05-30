<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><i class="fa fa-user"></i> <?php echo $user->fullname(); ?></h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-xs-3"><b>Company</b></div><div class="col-xs-6"><?php echo ($user->company_name ? $user->company : '-'); ?></div>
    </div>
    <div class="row">
        <div class="col-xs-3"><b>Name</b></div><div class="col-xs-6"><?php echo $user->fullname(); ?></div>
    </div>

    <h2 class="page-header"></h2>

    <div class="row">
        <div class="col-xs-3"><b>Email</b></div><div class="col-xs-6"><?php echo $user->email; ?></div>
    </div>

    <h2 class="page-header"></h2>

    <div class="row">
        <div class="col-xs-3"><b>Home Phone</b></div><div class="col-xs-6"><?php echo $user->home_phone; ?></div>
    </div>
    <div class="row">
        <div class="col-xs-3"><b>Mobile Phone</b></div><div class="col-xs-6"><?php echo $user->cell_phone; ?></div>
    </div>

    <h2 class="page-header"></h2>

    <div class="row">
        <div class="col-xs-3"><b>Address</b></div><div class="col-xs-6"><?php echo $user->address1 . ' ' . $user->address2; ?></div>
    </div>
    <div class="row">
        <div class="col-xs-3"><b>State</b></div><div class="col-xs-6"><?php echo $user->state; ?></div>
    </div>
    <div class="row">
        <div class="col-xs-3"><b>City</b></div><div class="col-xs-6"><?php echo $user->city; ?></div>
    </div>
    <div class="row">
        <div class="col-xs-3"><b>Zip Code</b></div><div class="col-xs-6"><?php echo $user->zip_code; ?></div>
    </div>
    <div class="row">
        <div class="col-xs-3"><b>Country</b></div><div class="col-xs-6"><?php echo ($user->country ? $user->country->name : ''); ?></div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

