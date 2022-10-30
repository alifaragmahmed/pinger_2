<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @includeIf('layouts.inc.head')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    @yield("css")

    <style>
        * {
            font-family:  sans-serif !important;
        }
        #sidebar-menu ul li a {
            font-size: 16px!important;
        }
    </style>
</head>
<body data-sidebar="dark">
     <!-- Loader -->
     <div id="preloader">
        <div id="status">
            <div class="spinner-chase">
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
                <div class="chase-dot"></div>
            </div>
        </div>
    </div>
    <div id="layout-wrapper">
        @includeIf('layouts.inc.header')
        @includeIf('layouts.inc.menu')
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('PageContent')
                    @includeIf('layouts.inc.footer')
                </div>
            </div>
        </div>
    </div>
    @includeIf('layouts.inc.footer')
    @includeIf('layouts.inc.right-bar')
    @includeIf('layouts.inc.scripts')
</body>
</html>
