<?php $uri = Request::path(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ APP_NAME }}</title>

    <!-- Bootstrap core CSS -->
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>

    <link rel="stylesheet" href="/assets/libs/bootstrap/bootstrap.min.css">
    <script src="/assets/libs/bootstrap/bootstrap.min.js"></script>

    <link rel="stylesheet" href="/assets/libs/font-awesome/css/font-awesome.min.css">

    <!-- Custom styles for this template -->
    <link href="/assets/css/guests/justified-nav.css" rel="stylesheet">

    <link rel="stylesheet" href="/assets/libs/parsleyjs/parsley.css">
    <script src="/assets/libs/parsleyjs/parsley.min.js"></script>
    <script src="/assets/libs/parsleyjs/es.js"></script>

    <link rel="stylesheet" href="/assets/libs/datatables/css/jquery.dataTables.min.css">
    <script src="/assets/libs/datatables/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" href="/assets/libs/bootstrap.vertical-tabs.min.css">

    <link rel="stylesheet" href="/assets/css/guests/main.css">
    <script src="/assets/js/guests.js"></script>

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="container">
        <div class="masthead">
            <div class="user-nav text-right">
                <a href="/login" class="btn btn-lg btn-default"><i class="fa fa-user"></i> Log In</a>
                <a href="/signup" class="btn btn-lg btn-primary">Register</a>
            </div>

        </div>

        {!! \App\Helpers\Flash::html() !!}

        @yield('content')

    </div>
    <script>
        $(function() {
            app.init();
        });
    </script>
</body>
</html>
