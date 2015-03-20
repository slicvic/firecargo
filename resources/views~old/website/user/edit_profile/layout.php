<h1 class="page-header">Perfil</h1>

<div class="alert alert-warning">
    Casillero: <?php echo $user->name(); ?> <b><?php echo $user->cid();?></b>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="col-md-2">
            <ul class="nav nav-tabs tabs-left">
                <li class="active"><a href="#general" data-toggle="tab">Datos</a></li>
                <li><a href="#email" data-toggle="tab"><?php echo Lang::get('messages.email'); ?></a></li>
                <li><a href="#password" data-toggle="tab"><?php echo Lang::get('messages.password2'); ?></a></li>
            </ul>
        </div>
        <div class="col-md-10">
            <div class="tab-content">
                <div class="flash"></div>
                <div class="tab-pane active" id="general">
                    <?php echo View::make('website.user.edit_profile.info'); ?>
                </div>
                <div class="tab-pane" id="email">
                    <?php echo View::make('website.user.edit_profile.email'); ?>
                </div>
                <div class="tab-pane" id="password">
                    <?php echo View::make('website.user.edit_profile.password'); ?>
                </div>            
            </div>
        </div>
    </div>
</div>