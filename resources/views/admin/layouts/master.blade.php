<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }}</title>

    <link href="/assets/plugins/inspinia/Static_Seed_Project/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/plugins/inspinia/Static_Seed_Project/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Mainly Scripts -->
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
    <script src="/assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="/assets/plugins/inspinia/Static_Seed_Project/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="/assets/plugins/inspinia/Static_Seed_Project/js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="/assets/plugins/inspinia/Static_Seed_Project/js/plugins/dataTables/dataTables.tableTools.min.js"></script>

    <!-- Form Validation -->
    <script src="/assets/plugins/inspinia/Static_Seed_Project/js/plugins/validate/jquery.validate.min.js"></script>
    <!--<script src="/assets/plugins/parsleyjs/parsley.min.js"></script>
    <link href="/assets/plugins/parsleyjs/parsley.css" rel="stylesheet">-->

    <!-- iCheck -->
    <script src="/assets/plugins/inspinia/Static_Seed_Project/js/plugins/iCheck/icheck.min.js"></script>
    <link href="/assets/plugins/inspinia/Static_Seed_Project/css/plugins/iCheck/custom.css" rel="stylesheet">

    <!-- Date Picker-->
    <script src="/assets/plugins/inspinia/Static_Seed_Project/js/plugins/datepicker/bootstrap-datepicker.js"></script>
    <link href="/assets/plugins/inspinia/Static_Seed_Project/css/plugins/datepicker/datepicker3.css" rel="stylesheet">

    <!-- jQuery UI -->
    <link rel="stylesheet" href="/assets/plugins/jquery-ui/jquery-ui.min.css">
    <script src="/assets/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- Toastr -->
    <link href="/assets/plugins/inspinia/Static_Seed_Project/css/plugins/toastr/toastr.min.css" rel="stylesheet">
    <script src="/assets/plugins/inspinia/Static_Seed_Project/js/plugins/toastr/toastr.min.js"></script>

    <!-- X-Editable -->
    <link href="/assets/plugins/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <script src="/assets/plugins/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

    <!-- Inspinia Styles -->
    <link href="/assets/plugins/inspinia/Static_Seed_Project/css/animate.css" rel="stylesheet">
    <link href="/assets/plugins/inspinia/Static_Seed_Project/css/style.css" rel="stylesheet">

    <!-- Main -->
    <link rel="stylesheet" type="text/css" href="/assets/admin/css/style.css">
    <script src="/assets/admin/js/app.js"></script>
</head>
<body>
    <div id="wrapper" class="{{ str_replace('/', ' ', $currentUri) }}">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <span><img alt="image" class="img-circle" src="{{ $currentUser->present()->profilePhotoUrl('sm', asset(env('APP_DEFAULT_AVATAR'))) }}" style="width:48px;height:48px"></span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                                    <span class="block m-t-xs"><strong class="font-bold">{{ $currentUser->present()->fullname() }}</strong></span>
                                    <span class="text-muted text-xs block">{{ $currentUser->role->name }} <b class="caret"></b></span>
                                </span>
                            </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="/user/profile">My Profile</a></li>
                                @if ($isAdminUser || $isAgentUser)
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

                    <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                        <a href="/dashboard"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
                    </li>

                    @if ($isAdminUser || $isAgentUser)

                        <li class="{{ (Request::is('warehouses') || Request::is('warehouse/*')) ? 'active' : '' }}">
                            <a href="#"><i class="fa fa-cube"></i> <span class="nav-label">Warehouses</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li class="{{ Request::is('warehouses') ? 'active' : '' }}"><a href="/warehouses">Warehouses</a></li>
                                <li class="{{ Request::is('warehouse/create') ? 'active' : '' }}"><a href="/warehouse/create">Create Warehouse</a></li>
                            </ul>
                        </li>

                        <li class="{{ (Request::is('shipments') || Request::is('shipment/*')) ? 'active' : '' }}">
                            <a href="#"><i class="fa fa-plane"></i> <span class="nav-label">Shipments</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li class="{{ Request::is('shipments') ? 'active' : '' }}"><a href="/shipments">Shipments</a></li>
                                <li class="{{ Request::is('shipment/create') ? 'active' : '' }}"><a href="/shipment/create">Create Shipment</a></li>
                            </ul>
                        </li>

                        <li class="{{ (Request::is('packages') || Request::is('package/*')) ? 'active' : '' }}">
                            <a href="/packages"><i class="fa fa-th"></i><span>Pieces</span></a>
                        </li>

                        <li class="{{ (Request::is('accounts') || Request::is('account/*')) ? 'active' : '' }}">
                            <a href="/accounts"><i class="fa fa-users"></i><span>Accounts</span></a>
                        </li>

                        <li{{ preg_match('/carrier|company|package-type|companies|role|user/', $currentUri) ? ' class=active' : '' }}>
                            <a href="#"><i class="fa fa-cog"></i> <span class="nav-label">Settings</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                @if ($isAdminUser)
                                    <li class="{{ (Request::is('users') || Request::is('user/*')) ? 'active' : '' }}"><a href="/users">Users</a></li>
                                    <li class="{{ (Request::is('companies') || Request::is('company/*')) ? 'active' : '' }}"><a href="/companies">Companies</a></li>
                                    <li class="{{ (Request::is('roles') || Request::is('role/*')) ? 'active' : '' }}"><a href="/roles">Roles</a></li>
                                    <li class="{{ (Request::is('package-types') || Request::is('package-type/*')) ? 'active' : '' }}"><a href="/package-types">Package Types</a></li>
                                    <li class="{{ (Request::is('carriers') || Request::is('carrier/*')) ? 'active' : '' }}"><a href="/carriers">Carriers</a></li>
                                @endif
                            </ul>
                        </li>
                    @endif

                </ul>

            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top{{ Request::is('dashboard') ? ' white-bg' : '' }}" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <span class="m-r-sm text-muted welcome-message">Welcome, {{ $currentUser->firstname }}!</span>
                        </li>
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
                    <strong>Copyright</strong> &copy; {{ date('Y') }}, {{ env('APP_COMPANY_NAME') }}
                </div>
            </div>
        </div>
    </div>
    <div class="modal inmodal" id="modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInRight"></div>
        </div>
    </div>
    {!! Flash::render('toastr') !!}
</body>
</html>
