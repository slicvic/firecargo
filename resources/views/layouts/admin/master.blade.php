<?php $user = Auth::user(); ?>
<?php $uri = Request::path(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ env('APP_NAME')}}</title>

    <link href="/assets/plugins/inspinia/Static_Seed_Project/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/plugins/inspinia/Static_Seed_Project/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="/assets/plugins/inspinia/Static_Seed_Project/css/animate.css" rel="stylesheet">
    <link href="/assets/plugins/inspinia/Static_Seed_Project/css/style.css" rel="stylesheet">

    <!-- Mainly scripts -->
    <script src="/assets/plugins/inspinia/Static_Seed_Project/js/jquery-2.1.1.js"></script>
    <script src="/assets/plugins/inspinia/Static_Seed_Project/js/bootstrap.min.js"></script>
    <script src="/assets/plugins/inspinia/Static_Seed_Project/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/assets/plugins/inspinia/Static_Seed_Project/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="/assets/plugins/inspinia/Static_Seed_Project/js/inspinia.js"></script>
    <script src="/assets/plugins/inspinia/Static_Seed_Project/js/plugins/pace/pace.min.js"></script>

    <!-- DataTables -->
    <link href="/assets/plugins/inspinia/Static_Seed_Project/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="/assets/plugins/inspinia/Static_Seed_Project/css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
    <script src="/assets/plugins/inspinia/Static_Seed_Project/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="/assets/plugins/inspinia/Static_Seed_Project/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="/assets/plugins/inspinia/Static_Seed_Project/js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="/assets/plugins/inspinia/Static_Seed_Project/js/plugins/dataTables/dataTables.tableTools.min.js"></script>

    <!-- Form Wizard -->
    <link href="/assets/plugins/inspinia/Static_Seed_Project/css/plugins/steps/jquery.steps.css" rel="stylesheet">
    <script src="/assets/plugins/inspinia/Static_Seed_Project/js/plugins/steps/jquery.steps.min.js"></script>

    <!-- Form Validation -->
    <script src="/assets/plugins/inspinia/Static_Seed_Project/js/plugins/validate/jquery.validate.min.js"></script>
    <!--<script src="/assets/plugins/parsleyjs/parsley.min.js"></script>
    <link href="/assets/plugins/parsleyjs/parsley.css" rel="stylesheet">-->

    <!-- iChecks -->
    <script src="/assets/plugins/inspinia/Static_Seed_Project/js/plugins/iCheck/icheck.min.js"></script>
    <link href="/assets/plugins/inspinia/Static_Seed_Project/css/plugins/iCheck/custom.css" rel="stylesheet">

    <!-- Date Picker-->
    <script src="/assets/plugins/inspinia/Static_Seed_Project/js/plugins/datepicker/bootstrap-datepicker.js"></script>
    <link href="/assets/plugins/inspinia/Static_Seed_Project/css/plugins/datepicker/datepicker3.css" rel="stylesheet">

    <!-- jQuery UI -->
    <link rel="stylesheet" href="/assets/plugins/jquery-ui/jquery-ui.min.css">
    <script src="/assets/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- Main -->
    <link rel="stylesheet" type="text/css" href="/assets/admin/css/style.css">
    <script src="/assets/admin/js/app.js"></script>

    <script>var csrfToken = '{{ csrf_token() }}';</script>
</head>

<body>

    <div id="wrapper">

        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <span><img alt="image" class="img-circle" src="{{ Auth::user()->present()->profilePhotoUrl() }}" style="width:48px;height:48px"></span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                                    <span class="block m-t-xs"><strong class="font-bold">{{ $user->present()->fullname() }}</strong></span>
                                    <span class="text-muted text-xs block">{{ $user->role->name }} <b class="caret"></b></span>
                                </span>
                            </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="/user/profile">My Profile</a></li>
                                @if ( ! Auth::user()->isClient())
                                    <li><a href="/company/profile">Company Profile</a></li>
                                @endif
                                <li class="divider"></li>
                                <li><a href="/logout">Logout</a></li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            FC
                        </div>
                    </li>

                    <li class="{{ ('dashboard' == $uri) ? 'active' : '' }}">
                        <a href="/dashboard"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
                    </li>

                    @if ($user->isAdmin() || $user->isAgent())

                        <li{{ preg_match('/shipments/', $uri) ? ' class=active' : '' }}>
                            <a href="#"><i class="fa fa-plane"></i> <span class="nav-label">Shipments</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li{{ (Request::is('shipments')) ? ' class=active' : '' }}><a href="/shipments">Shipments</a></li>
                                <li{{ (Request::is('shipments/create')) ? ' class=active' : '' }}><a href="/shipments/create">Create Shipment</a></li>
                            </ul>
                        </li>

                        <li{{ preg_match('/warehouse/', $uri) ? ' class=active' : '' }}>
                            <a href="#"><i class="fa fa-cube"></i> <span class="nav-label">Warehouses</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li{{ (Request::is('warehouses')) ? ' class=active' : '' }}><a href="/warehouses">Warehouses</a></li>
                                <li{{ (Request::is('warehouses/create')) ? ' class=active' : '' }}><a href="/warehouses/create">Create Warehouse</a></li>
                            </ul>
                        </li>

                        <li{{ (Request::is('accounts') || Request::is('accounts/*')) ? ' class=active' : '' }}>
                            <a href="/accounts"><i class="fa fa-users"></i><span>Accounts</span></a>
                        </li>

                        <li{{ preg_match('/carriers|sites|company|package-|companies|roles|users/', $uri) ? ' class=active' : '' }}>
                            <a href="#"><i class="fa fa-cog"></i> <span class="nav-label">Settings</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                @if ($user->isAdmin())
                                    <li{{ (Request::is('users') || Request::is('users/*')) ? ' class=active' : '' }}><a href="/users">Users</a></li>
                                    <li{{ (Request::is('companies') || Request::is('companies/*')) ? ' class=active' : '' }}><a href="/companies">Companies</a></li>
                                    <li{{ (Request::is('roles') || Request::is('roles/*')) ? ' class=active' : '' }}><a href="/roles">Roles</a></li>
                                    <li{{ (Request::is('package-types') || Request::is('package-types/*')) ? ' class=active' : '' }}><a href="/package-types">Package Types</a></li>
                                    <li{{ (Request::is('carriers') || Request::is('carriers/*')) ? ' class=active' : '' }}><a href="/carriers">Carriers</a></li>
                                    <li{{ (Request::is('sites') || Request::is('sites/*')) ? ' class=active' : '' }}><a href="/sites">Sites</a></li>
                                @endif
                                <li{{ (Request::is('company') || Request::is('company/*')) ? ' class=active' : '' }}><a href="/company/profile">Company Profile</a></li>
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
                    <strong>Copyright</strong> {{ env('APP_NAME') }} &copy; 2014-{{ date('Y') }}
                </div>
            </div>
        </div>
    </div>
    <div class="modal inmodal" id="modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInRight"></div>
        </div>
    </div>
</body>

</html>
