<?php $user = Auth::user(); ?>
<?php $uri = Request::path(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>App</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="/assets/vendor/templates/detail/css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="/assets/vendor/templates/detail/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

    <link href="/assets/vendor/templates/detail/css/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="/assets/vendor/templates/detail/css/compiled/layout.css" />
    <link rel="stylesheet" type="text/css" href="/assets/vendor/templates/detail/css/compiled/elements.css" />
    <link rel="stylesheet" type="text/css" href="/assets/vendor/templates/detail/css/compiled/form-showcase.css" />

    <link rel="stylesheet" href="/assets/vendor/templates/detail/css/compiled/index.css" type="text/css" media="screen" />

<!--    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css' />

    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css' />-->

    <link href="/assets/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="/assets/vendor/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/admin/css/main.css" />

    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="/assets/vendor/templates/detail/js/bootstrap.min.js"></script>
    <script src="/assets/vendor/templates/detail/js/jquery-ui-1.10.2.custom.min.js"></script>
    <script src="/assets/vendor/templates/detail/js/theme.js"></script>
    <script src="/assets/vendor/datatables/js/jquery.dataTables.min.js" type="text/javascript"></script>

    <link rel="stylesheet" href="/assets/vendor/parsleyjs/parsley.css">
    <script src="/assets/vendor/parsleyjs/parsley.min.js"></script>

    <script src="/assets/admin/js/main.js"></script>
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
            <a class="navbar-brand" href="/dashboard">
                <b><?php echo $user->site->name; ?></b>
            </a>
        </div>
        <ul class="nav navbar-nav pull-right hidden-xs">

            <li class="dropdown">
                <a href="#" class="dropdown-toggle hidden-xs hidden-sm" data-toggle="dropdown">
                    <i class="fa fa-user"></i> Howdy, <?php echo $user->getFullName(); ?>
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

            <?php if ($user->isClient()): ?>
                <li class="<?php echo ('account/profile' == $uri || 'account/password' == $uri) ? 'active' : ''; ?>">
                    <?php echo ('account/profile' == $uri || 'account/password' == $uri) ? \App\Helpers\Html::sideNavPointer() : ''; ?>
                    <a href="/account/profile">
                        <i class="fa fa-user"></i>
                        <span>My Account</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($user->isAdmin() || $user->isAgent()): ?>
                <li class="<?php $warehouse_menu_active = preg_match('/warehouse/', $uri); echo ($warehouse_menu_active) ? 'active' : ''; ?>">
                    <?php echo ($warehouse_menu_active) ? \App\Helpers\Html::sideNavPointer() : ''; ?>
                    <a class="dropdown-toggle" href="#">
                        <i class="fa fa-cube"></i>
                        <span>Warehouse</span>
                        <i class="fa fa-chevron-down icon-chevron-down"></i>
                    </a>
                    <ul class="submenu <?php echo ($warehouse_menu_active) ? 'active' : ''; ?>">
                        <li><a href="/warehouses" class="<?php echo (Request::is('warehouses')) ? 'active' : ''; ?>">Warehouses</a></li>
                        <li><a href="/warehouses/create" class="<?php echo (Request::is('warehouses/create')) ? 'active' : ''; ?>">Create Warehouse</a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($user->isAdmin() || $user->isAgent()): ?>
                <li class="<?php $accounts_menu_active = (Request::is('accounts') || Request::is('accounts/*')); echo ($accounts_menu_active) ? 'active' : ''; ?>">
                    <?php echo ($accounts_menu_active) ? \App\Helpers\Html::sideNavPointer() : ''; ?>
                    <a href="/accounts">
                        <i class="fa fa-users"></i>
                        <span>Accounts</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($user->isAdmin() || $user->isAgent()): ?>
                <li class="<?php $admin_menu_active = preg_match('/couriers|sites|company|package-|companies|roles/', $uri); echo ($admin_menu_active) ? 'active' : ''; ?>">
                    <?php echo ($admin_menu_active) ? \App\Helpers\Html::sideNavPointer() : ''; ?>
                    <a class="dropdown-toggle" href="#">
                        <i class="fa fa-cog"></i>
                        <span>Settings</span>
                        <i class="fa fa-chevron-down icon-chevron-down"></i>
                    </a>
                    <ul class="submenu <?php echo ($admin_menu_active) ? 'active' : ''; ?>">
                        <?php if ($user->isAdmin()): ?>
                            <li><a href="/roles" class="<?php echo (Request::is('roles') || Request::is('roles/*')) ? 'active' : ''; ?>">Roles</a></li>
                            <li><a href="/companies" class="<?php echo (Request::is('companies') || Request::is('companies/*')) ? 'active' : ''; ?>">Companies</a></li>
                            <li><a href="/sites" class="<?php echo (Request::is('sites') || Request::is('sites/*')) ? 'active' : ''; ?>">Sites</a></li>
                            <li><a href="/package-types" class="<?php echo (Request::is('package-types') || Request::is('package-types/*')) ? 'active' : ''; ?>">Package Types</a></li>
                        <?php endif; ?>
                        <li><a href="/company/profile" class="<?php echo (Request::is('company') || Request::is('company/*')) ? 'active' : ''; ?>">Company</a></li>
                        <li><a href="/couriers" class="<?php echo (Request::is('couriers') || Request::is('couriers/*')) ? 'active' : ''; ?>">Couriers</a></li>
                        <li><a href="/package-statuses" class="<?php echo (Request::is('package-statuses') || Request::is('package-statuses/*')) ? 'active' : ''; ?>">Package Statuses</a></li>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <!-- end sidebar -->

    <div class="content">
        <div id="pad-wrapper">
            <?php echo \App\Helpers\Flash::getHTML(); ?>
            @yield('content')
        </div>
    </div>
</body>
</html>
