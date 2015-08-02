<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title{{ env('APP_NAME') }}</title>

    <link href="/assets/plugins/inspinia/Static_Seed_Project/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/plugins/inspinia/Static_Seed_Project/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="/assets/plugins/inspinia/Static_Seed_Project/css/animate.css" rel="stylesheet">
    <link href="/assets/plugins/inspinia/Static_Seed_Project/css/style.css" rel="stylesheet">

    <script src="/assets/plugins/inspinia/Static_Seed_Project/js/jquery-2.1.1.js"></script>
    <script src="/assets/plugins/inspinia/Static_Seed_Project/js/bootstrap.min.js"></script>

    <script src="/assets/plugins/inspinia/Static_Seed_Project/js/plugins/validate/jquery.validate.min.js"></script>

    <script src="/assets/auth/js/main.js"></script>
</head>

<body class="gray-bg">
    <div class="passwordBox animated fadeInDown">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center" style="margin-bottom:30px;">{!! env('APP_NAME_HTML') !!}</h1>
                @yield('content')
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6">
                {{ env('APP_COMPANY_NAME') }}
            </div>
            <div class="col-md-6 text-right">
               <small>&copy; 2014-{{ date('Y') }}</small>
            </div>
        </div>
    </div>

    {!! Flash::getToastr() !!}
</body>
</html>
