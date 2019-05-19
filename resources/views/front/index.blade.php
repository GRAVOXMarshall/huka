<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href='@if(isset($template) && $template->active === 1) {{ asset("css/template/$template->route_js") }} @endif'>
    </head>
    <body>
        <!-- Navbar -->
        <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
          <h5 class="my-0 mr-md-auto font-weight-normal">Company name</h5>
          <nav class="my-2 my-md-0 mr-md-3">
            <a class="p-2 text-dark" href="/">Home</a>
            <a class="p-2 text-dark" href="#">Features</a>
            <a class="p-2 text-dark" href="#">Support</a>
            <a class="p-2 text-dark" href="#">Contact Us</a>
            <form action="{{ route('logout') }}" method="post">
              @csrf
              <input type="submit" value="salir" name="">
            </form>
          </nav>
          @if(Auth::guard('front')->user())
            <a href="#">{{ Auth::guard('front')->user()->email }}</a>
          @else
            <a class="btn btn-outline-warning" href="{{ route('login') }}">Sign up</a>
          @endif
          
        </div>
        <!-- End Navbar -->

        <!-- Content -->
        @yield('content')
        <!-- End Content -->

        <!-- Footer -->
        <hr class="featurette-divider">
        <div class="container">
          <footer class="pt-4 my-md-5 pt-md-5">
            <div class="row">
              <div class="col-12 col-md">
                <h5 class="my-0 mr-md-auto font-weight-normal">Company name</h5>
              </div>
              <div class="col-6 col-md">
                <h5>Features</h5>
                <ul class="list-unstyled text-small">
                  <li><a class="text-muted" href="#">Cool stuff</a></li>
                  <li><a class="text-muted" href="#">Random feature</a></li>
                  <li><a class="text-muted" href="#">Team feature</a></li>
                  <li><a class="text-muted" href="#">Stuff for developers</a></li>
                  <li><a class="text-muted" href="#">Another one</a></li>
                  <li><a class="text-muted" href="#">Last time</a></li>
                </ul>
              </div>
              <div class="col-6 col-md">
                <h5>Resources</h5>
                <ul class="list-unstyled text-small">
                  <li><a class="text-muted" href="#">Resource</a></li>
                  <li><a class="text-muted" href="#">Resource name</a></li>
                  <li><a class="text-muted" href="#">Another resource</a></li>
                  <li><a class="text-muted" href="#">Final resource</a></li>
                </ul>
              </div>
              <div class="col-6 col-md">
                <h5>About</h5>
                <ul class="list-unstyled text-small">
                  <li><a class="text-muted" href="#">Team</a></li>
                  <li><a class="text-muted" href="#">Locations</a></li>
                  <li><a class="text-muted" href="#">Privacy</a></li>
                  <li><a class="text-muted" href="#">Terms</a></li>
                </ul>
              </div>
            </div>
            <!-- Copyright -->
            <div class="footer-copyright text-center py-3">
                <small class="text-muted">© 2019 - Open source software developed by Creativing X</small>
            </div>
            <!-- Copyright -->
          </footer>
        </div>
        <!-- End Footer -->

        <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
    </body>
</html>