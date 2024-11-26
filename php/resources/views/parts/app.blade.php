<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Facilease</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    @include('parts.header')
</head>
<body class="{{auth('admin')->check() ? '' : 'toggle-sidebar'}}">

<header id="header" class="header fixed-top d-flex align-items-center">
    @include('parts.top_header')
</header><!-- End Header -->

@auth('admin')
<aside id="sidebar" class="sidebar">
   @include('parts.aside')
</aside>
@endauth

<main id="main" class="main">
    @include('parts.msg')
    @yield('content')
</main>

<footer id="footer" class="footer">
    <div class="copyright">
        &copy; Copyright <strong><span>Facilease</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
        Designed by <a href="#">Facilease</a>
    </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

@include('parts.footer')
</body>
</html>
