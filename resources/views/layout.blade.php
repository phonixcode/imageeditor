<!DOCTYPE html>
<html lang="en">


<head>
    <title>@yield('title') - Image Editor</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Image Editor" />
    <meta name="author" content="Qudus" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- app favicon -->
    <link rel="shortcut icon" href="assets/img/favicon.ico">
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <!-- plugin stylesheets -->
    <link rel="stylesheet" type="text/css" href="assets/css/vendors.css" />
    <!-- app style -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
    @stack('style')
</head>

<body class="sidebar-mini">
    <!-- begin app -->
    <div class="app">
        <!-- begin app-wrap -->
        <div class="app-wrap">

            <!-- begin app-header -->
            <header class="app-header top-bar">
                <!-- begin navbar -->
                <nav class="navbar navbar-expand-md">
                    <!-- begin navigation -->
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <div class="navigation d-flex">
                            <ul class="navbar-nav nav-left">
                                <li class="nav-item active">
                                    <a class="nav-link " href="{{ route('cleanup.view') }}">
                                        Cleanup Image
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('removeBackground.view') }}" class="nav-link">
                                        Remove Background Image
                                    </a>
                                </li>
                                @auth
                                <li class="nav-item">
                                    <a href="{{ route('api.key.setting') }}" class="nav-link">
                                        Api key Setting
                                    </a>
                                </li>
                                @endauth

                            </ul>

                            @auth
                            <ul class="navbar-nav nav-right ml-auto">
                                <li class="nav-item">
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="nav-link">
                                        Logout
                                    </a>
                                </li>
                            </ul>

                            <form action="{{ route('logout') }}" method="post" class="d-none"
                                        id="logout-form">@csrf</form>
                            @endauth

                        </div>
                    </div>
                    <!-- end navigation -->
                </nav>
                <!-- end navbar -->
            </header>
            <!-- end app-header -->
            <!-- begin app-container -->
            <div class="app-container">
                <!-- begin app-main -->
                <div class="app-main" id="main">
                    <!-- begin container-fluid -->
                    @yield('content')
                    <!-- end container-fluid -->
                </div>
                <!-- end app-main -->
            </div>
            <!-- end app-container -->
        </div>
        <!-- end app-wrap -->
    </div>
    <!-- end app -->

    <!-- plugins -->
    <script src="assets/js/vendors.js"></script>

    <!-- custom app -->
    <script src="assets/js/app.js"></script>
    @stack('js')
</body>


</html>
