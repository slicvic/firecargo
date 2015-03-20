<div class="row">
    <div class="col-md-4 text-center">
        <div class="row">
            <img src="/assets/img/avatar.png" class="img-circle">
            <h3><?php echo Auth::user()->name(); ?></h3>
            <h5>Casillero ID: <?php echo Auth::user()->cid(); ?></h5>
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Account</strong></div>
                <div class="list-group">
                    <a href="/account/profile" class="list-group-item"><i class="fa fa-user"></i> Update Profile</a>
                    <a href="/account/password" class="list-group-item"><i class="fa fa-lock"></i> Change Password</a>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-8">
        <?php echo $content; ?>
    </div>
</div>
