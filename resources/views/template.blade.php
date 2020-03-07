<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="/css/app.css">
        <title>@yield('title', 'Workshop')</title>
    </head>

    <body>

        <div class="ws-message position-fixed <?= (session('success') ? "ws-message-visible" : "") ?>">
            <div class="d-flex position-relative align-items-center">
                <i class="fas fa-times-circle close-message"></i>
                <i class="fas fa-smile-wink message-icon"></i>
                <p class="ws-message-content">{{session('success')}}</p>
            </div>
        </div>
        <div class="ws-navbar-container fixed-top">
            @include('_navigation')
        </div>

        <div class="scroll-button">
            <i class="fa fa-chevron-down"></i>
        </div>


        @yield('main')

        <footer class="py-5 ws-footer">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-6 col-12 text-center">
                        <img src="/img/logo.png" class="logo" alt="Websites logo" />
                        <div class="d-flex justify-content-center footer-menu">
                            <a class="nav-link" href="{{url('')}}">Home</a>
                            <a class="nav-link" href="{{url('posts')}}">Posts</a>
                            <a class="nav-link" href="{{url('users')}}">Users</a>
                            <a class="nav-link" href="{{url('contact')}}">Contact Us</a>
                        </div>
                        <p class="copyright">&copy; 2020 Edijs Apse</p>
                    </div>
                </div>
            </div>
        </footer>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/04d31d0667.js" crossorigin="anonymous"></script>
        <script src="/js/custom.js"></script>
        @yield('js')
    </body>
</html>
