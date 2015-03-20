<?php $user = Auth::user(); ?>
<?php $uri = Request::path(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Detail Admin - Home</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="/assets/libs/detail-template/css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="/assets/libs/detail-template/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

    <link href="/assets/libs/detail-template/css/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="/assets/libs/detail-template/css/compiled/layout.css" />
    <link rel="stylesheet" type="text/css" href="/assets/libs/detail-template/css/compiled/elements.css" />
    <link rel="stylesheet" type="text/css" href="/assets/libs/detail-template/css/compiled/form-showcase.css" />

    <link rel="stylesheet" href="/assets/libs/detail-template/css/compiled/index.css" type="text/css" media="screen" />

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css' />

    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css' />

    <link href="/assets/libs/datatables/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="/assets/libs/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/admin.css" />

    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="/assets/libs/detail-template/js/bootstrap.min.js"></script>
    <script src="/assets/libs/detail-template/js/jquery-ui-1.10.2.custom.min.js"></script>
    <script src="/assets/libs/detail-template/js/theme.js"></script>
    <script src="/assets/libs/datatables/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="/assets/js/admin.js"></script>
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
                    <li><a href="/logout">Log out</a></li>
                </ul>
            </li>
        </ul>
    </header>
    <!-- end navbar -->

    <!-- sidebar -->
    <div id="sidebar-nav">
        <ul id="dashboard-menu">
            <li class="">
                <div class="pointer">
                    <div class="arrow"></div>
                    <div class="arrow_border"></div>
                </div>
                <a href="index.html">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="<?php echo (strpos($uri, 'warehouse') !== FALSE ? 'active' : ''); ?>">
                <a class="dropdown-toggle" href="#">
                    <i class="fa fa-cube"></i>
                    <span>Warehouse</span>
                    <i class="fa fa-chevron-down icon-chevron-down"></i>
                </a>
                <ul class="submenu <?php echo (strpos($uri, 'warehouse') !== FALSE ? 'active' : ''); ?>">
                    <li><a href="/admin/warehouses" class="<?php echo (Request::is('admin/warehouses') || Request::is('admin/warehouses/*') ? 'active' : ''); ?>">Warehouses</a></li>
                    <li><a href="/admin/warehousestatuses">Statuses</a></li>
                    <li><a href="/admin/couriers">Couriers</a></li>
                </ul>
            </li>

            <?php if ($user->isAdmin()): ?>
                <li class="<?php echo (strpos($uri, 'warehouse') !== FALSE ? 'active' : ''); ?>">
                    <a class="dropdown-toggle" href="#">
                        <i class="fa fa-cog"></i>
                        <span>Admin</span>
                        <i class="fa fa-chevron-down icon-chevron-down"></i>
                    </a>
                    <ul class="submenu">
                        <?php if ($user->isMaster()): ?>
                            <li><a href="/admin/users" class="<?php echo (Request::is('admin/users') || Request::is('admin/users/*')  ? 'active' : ''); ?>">Accounts</a></li>
                            <li><a href="/admin/companies">Roles</a></li>
                            <li><a href="/admin/companies">Companies</a></li>
                        <?php else: ?>
                            <li><a href="/admin/users" class="<?php echo (Request::is('admin/users') || Request::is('admin/users/*')  ? 'active' : ''); ?>">Accounts</a></li>
                            <li><a href="/admin/companies">Company</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <!-- end sidebar -->

    <div class="content">
        <div id="pad-wrapper">
            <?php echo (isset($content) ? $content : ''); ?>
        </div>
    </div>
</body>
</html>
