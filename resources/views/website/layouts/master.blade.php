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
</head>

<body class="gray-bg">
    @yield('content')
    <script>
        $(function() {
            $('form').validate();
        });
    </script>
</body>
</html>
