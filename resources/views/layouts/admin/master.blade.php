<?php $user = Auth::user(); ?>
<?php $uri = Request::path(); ?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ env('APP_NAME')}}</title>

    <link href="/assets/vendor/inspinia/Static_Seed_Project/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/vendor/inspinia/Static_Seed_Project/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="/assets/vendor/inspinia/Static_Seed_Project/css/animate.css" rel="stylesheet">
    <link href="/assets/vendor/inspinia/Static_Seed_Project/css/style.css" rel="stylesheet">

    <!-- Mainly scripts -->
    <script src="/assets/vendor/inspinia/Static_Seed_Project/js/jquery-2.1.1.js"></script>
    <script src="/assets/vendor/inspinia/Static_Seed_Project/js/bootstrap.min.js"></script>
    <script src="/assets/vendor/inspinia/Static_Seed_Project/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/assets/vendor/inspinia/Static_Seed_Project/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="/assets/vendor/inspinia/Static_Seed_Project/js/inspinia.js"></script>
    <script src="/assets/vendor/inspinia/Static_Seed_Project/js/plugins/pace/pace.min.js"></script>

    <!-- DataTables -->
    <link href="/assets/vendor/inspinia/Static_Seed_Project/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="/assets/vendor/inspinia/Static_Seed_Project/css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
    <script src="/assets/vendor/inspinia/Static_Seed_Project/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="/assets/vendor/inspinia/Static_Seed_Project/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="/assets/vendor/inspinia/Static_Seed_Project/js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="/assets/vendor/inspinia/Static_Seed_Project/js/plugins/dataTables/dataTables.tableTools.min.js"></script>

    <!-- Parsley Validation -->
    <link rel="stylesheet" href="/assets/vendor/parsleyjs/parsley.css">
    <script src="/assets/vendor/parsleyjs/parsley.min.js"></script>

    <!-- Main -->
    <link rel="stylesheet" type="text/css" href="/assets/admin/css/main.css" />
</head>

<body class="">

    <div id="wrapper">

        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <span><img alt="image" class="img-circle" src="{{ Auth::user()->getProfilePhotoUrl() ?: Auth::user()->getDefaultProfilePhotoUrl() }}" style="width:48;height:48"></span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                                    <span class="block m-t-xs"><strong class="font-bold">{{ $user->getFullName() }}</strong> <b class="caret"></b></span>
                                </span>
                                </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="/account/profile">Profile</a></li>
                                <li class="divider"></li>
                                <li><a href="/logout">Logout</a></li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            IN+
                        </div>
                    </li>

                    <li class="{{ ('dashboard' == $uri) ? 'active' : '' }}">
                        <a href="/dashboard"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
                    </li>

                    @if ($user->isAdmin() || $user->isAgent())
                        <li{{ preg_match('/warehouse/', $uri) ? ' class=active' : '' }}>
                            <a href="#"><i class="fa fa-cube"></i> <span class="nav-label">Warehouse</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li{{ (Request::is('warehouses')) ? ' class=active' : '' }}><a href="/warehouses">Warehouses</a></li>
                                <li{{ (Request::is('warehouses/create')) ? ' class=active' : '' }}><a href="/warehouses/create">Create Warehouse</a></li>
                            </ul>
                        </li>

                        <li{{ (Request::is('accounts') || Request::is('accounts/*')) ? ' class=active' : '' }}>
                            <a href="/accounts"><i class="fa fa-users"></i><span>Accounts</span></a>
                        </li>

                        <li{{ preg_match('/couriers|sites|company|package-|companies|roles/', $uri) ? ' class=active' : '' }}>
                            <a href="#"><i class="fa fa-cog"></i> <span class="nav-label">Settings</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <?php if ($user->isAdmin()): ?>
                                    <li{{ (Request::is('roles') || Request::is('roles/*')) ? ' class=active' : '' }}><a href="/roles">Roles</a></li>
                                    <li{{ (Request::is('companies') || Request::is('companies/*')) ? ' class=active' : '' }}><a href="/companies">Companies</a></li>
                                    <li{{ (Request::is('sites') || Request::is('sites/*')) ? ' class=active' : '' }}><a href="/sites">Sites</a></li>
                                    <li{{ (Request::is('package-types') || Request::is('package-types/*')) ? ' class=active' : '' }}><a href="/package-types">Package Types</a></li>
                                <?php endif; ?>
                                <li{{ (Request::is('company') || Request::is('company/*')) ? ' class=active' : '' }}><a href="/company/profile">Company</a></li>
                                <li{{ (Request::is('couriers') || Request::is('couriers/*')) ? ' class=active' : '' }}><a href="/couriers">Couriers</a></li>
                                <li{{ (Request::is('package-statuses') || Request::is('package-statuses/*')) ? ' class=active' : '' }}><a href="/package-statuses">Package Statuses</a></li>
                            </ul>
                        </li>
                    @endif

                </ul>

            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <a href="/logout">
                                <i class="fa fa-sign-out"></i> Log out
                            </a>
                        </li>
                    </ul>

                </nav>
            </div>

            @yield('content')

            <div class="footer">
                <div>
                    <strong>Copyright</strong> {{ env('APP_NAME') }} &copy; 2015-{{ date('Y') }}
                </div>
            </div>
        </div>
    </div>
</body>

</html>
