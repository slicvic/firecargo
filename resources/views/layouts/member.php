<?php $user = Auth::user(); ?>
<?php $uri = Request::path();
//echo '<pre>';print_r(Route::currentRouteAction());
?>
<!DOCTYPE html>
<html>
<head>
    <title>Detail Admin - Home</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="/assets/libs/templates/detail/css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="/assets/libs/templates/detail/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

    <link href="/assets/libs/templates/detail/css/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="/assets/libs/templates/detail/css/compiled/layout.css" />
    <link rel="stylesheet" type="text/css" href="/assets/libs/templates/detail/css/compiled/elements.css" />
    <link rel="stylesheet" type="text/css" href="/assets/libs/templates/detail/css/compiled/form-showcase.css" />

    <link rel="stylesheet" href="/assets/libs/templates/detail/css/compiled/index.css" type="text/css" media="screen" />

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css' />

    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css' />

    <link href="/assets/libs/datatables/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="/assets/libs/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/member.css" />

    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="/assets/libs/templates/detail/js/bootstrap.min.js"></script>
    <script src="/assets/libs/templates/detail/js/jquery-ui-1.10.2.custom.min.js"></script>
    <script src="/assets/libs/templates/detail/js/theme.js"></script>
    <script src="/assets/libs/datatables/js/jquery.dataTables.min.js" type="text/javascript"></script>

    <link rel="stylesheet" href="/assets/libs/parsleyjs/parsley.css">
    <script src="/assets/libs/parsleyjs/parsley.min.js"></script>

    <script src="/assets/js/member.js"></script>
    <script>
        $(function() {
            app.init();
        });
    </script>
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
    <!-- navbar -->
    <header class="navbar navbar-inverse" role="banner">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" id="menu-toggler">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.html">
                <b><?php echo APP_NAME; ?></b> Admin
            </a>
        </div>
        <ul class="nav navbar-nav pull-right hidden-xs">

            <li class="dropdown">
                <a href="#" class="dropdown-toggle hidden-xs hidden-sm" data-toggle="dropdown">
                    <?php echo $user->name(); ?>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="/account/profile">My Account</a></li>
                    <li class="divider"></li>
                    <li><a href="/logout">Log Out</a></li>
                </ul>
            </li>
        </ul>
    </header>
    <!-- end navbar -->

    <!-- sidebar -->
    <div id="sidebar-nav">
        <ul id="dashboard-menu">
            <li class="<?php echo ('dashboard' == $uri) ? 'active' : ''; ?>">
                <?php echo ('dashboard' == $uri) ? \App\Helpers\Html::sideNavPointer() : ''; ?>
                <a href="/dashboard">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <?php if ($user->isAdmin() || $user->isMerchant()): ?>
                <li class="<?php $warehouse_menu_active = preg_match('/warehouse|statuses|carriers/', $uri); echo ($warehouse_menu_active) ? 'active' : ''; ?>">
                    <?php echo ($warehouse_menu_active) ? \App\Helpers\Html::sideNavPointer() : ''; ?>
                    <a class="dropdown-toggle" href="#">
                        <i class="fa fa-cube"></i>
                        <span>Warehouse</span>
                        <i class="fa fa-chevron-down icon-chevron-down"></i>
                    </a>
                    <ul class="submenu <?php echo ($warehouse_menu_active) ? 'active' : ''; ?>">
                        <li><a href="/warehouses" class="<?php echo (Request::is('warehouses') || Request::is('warehouses/*')) ? 'active' : ''; ?>">Warehouses</a></li>
                        <li><a href="/statuses" class="<?php echo (Request::is('statuses') || Request::is('statuses/*')) ? 'active' : ''; ?>">Statuses</a></li>
                        <li><a href="/carriers" class="<?php echo (Request::is('carriers') || Request::is('carriers/*')) ? 'active' : ''; ?>">Shipping Carriers</a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($user->isAdmin()): ?>
                <li class="<?php $admin_menu_active = preg_match('/accounts|companies|roles/', $uri); echo ($admin_menu_active) ? 'active' : ''; ?>">
                    <?php echo ($admin_menu_active) ? \App\Helpers\Html::sideNavPointer() : ''; ?>
                    <a class="dropdown-toggle" href="#">
                        <i class="fa fa-cog"></i>
                        <span>Admin</span>
                        <i class="fa fa-chevron-down icon-chevron-down"></i>
                    </a>
                    <ul class="submenu <?php echo ($admin_menu_active) ? 'active' : ''; ?>">
                        <li><a href="/accounts" class="<?php echo (Request::is('accounts') || Request::is('accounts/*')) ? 'active' : ''; ?>">Accounts</a></li>
                        <li><a href="/roles" class="<?php echo (Request::is('roles') || Request::is('roles/*')) ? 'active' : ''; ?>">Roles</a></li>
                        <li><a href="/companies" class="<?php echo (Request::is('companies') || Request::is('companies/*')) ? 'active' : ''; ?>">Companies</a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($user->isClient()): ?>
                <li class="<?php $account_menu_active = (Request::is('account') || Request::is('account/*')); echo ($account_menu_active) ? 'active' : ''; ?>">
                    <?php echo ($account_menu_active) ? \App\Helpers\Html::sideNavPointer() : ''; ?>
                    <a href="/account/profile">
                        <i class="fa fa-users"></i>
                        <span>My Account</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($user->isMerchant()): ?>
                <li class="<?php $accounts_menu_active = (Request::is('accounts') || Request::is('accounts/*')); echo ($accounts_menu_active) ? 'active' : ''; ?>">
                    <?php echo ($accounts_menu_active) ? \App\Helpers\Html::sideNavPointer() : ''; ?>
                    <a href="/accounts">
                        <i class="fa fa-users"></i>
                        <span>Accounts</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <!-- end sidebar -->

    <div class="content">
        <div id="pad-wrapper">
            <?php echo \App\Helpers\Flash::html(); ?>
            <?php echo $content; ?>
        </div>
    </div>
</body>
</html>
