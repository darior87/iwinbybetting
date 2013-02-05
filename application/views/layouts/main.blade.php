<!DOCTYPE html>
<html>
<head>
<title>iWinByBetting - Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="<?php echo URL::base()?>/css/bootstrap-responsive.css" rel="stylesheet">
<link href="<?php echo URL::base()?>/css/bootstrap.css" rel="stylesheet" media="screen">
<link href="<?php echo URL::base()?>/js/bootstrap-fileupload.css" rel="stylesheet" media="screen">
</head>
<body>
    <script src="<?php echo URL::base()?>/jquery/jquery-1.8.2.min.js"></script>
    <script src="<?php echo URL::base()?>/js/bootstrap.js"></script>
    <script src="<?php echo URL::base()?>/js/bootstrap-fileupload.js"></script>
    <script src="<?php echo URL::base()?>/js/main.js"></script>
    
    <div class="container">
        <h1>@yield('title')</h1>
            <ul class="nav nav-tabs">
               @yield('menu')
            </ul>
            @yield('content')
    </div>
</body>
</html>