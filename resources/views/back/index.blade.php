<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <style type="text/css">/* Chart.js */
    @-webkit-keyframes chartjs-render-animation{
      from{opacity:0.99}to{opacity:1}
    }
    @keyframes chartjs-render-animation{
      from{opacity:0.99}to{opacity:1}
    }
    .chartjs-render-monitor{
    -webkit-animation:chartjs-render-animation 0.001s;animation:chartjs-render-animation 0.001s;
    }
    </style>
  </head>
  <body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Company name</a>
      <ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
        @if(Auth::guard('admins')->user())
              <p style="color: white;">{{ Auth::guard('admins')->user()->email }}</p>
            @endif
        <li class="nav-item">
          <a class="nav-link p-2" href="{{ route('select.editor') }}" rel="noopener" aria-label="GitHub">Edit Web</a>
        </li>
        <li class="nav-item">
          <a class="nav-link p-2" href="#" target="_blank" rel="noopener" aria-label="GitHub">View Web</a>
        </li>
      </ul>
      <form action="{{ route('admin.logout') }}" method="post"> 
        @csrf
        <button class="btn btn-primary d-none d-lg-inline-block mb-3 mb-md-0 ml-md-3">Sing out</button>
      </form>
    </nav>
    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link @if(request()->is('admin/dashboard')) active @endif" href="{{ route('dash.init') }}">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                  Dashboard <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link @if(request()->is('admin/dashboard/functionality')) active @endif" href="{{ route('dash.functionality') }}">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                  Functionalities
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link @if(request()->is('admin/dashboard/template')) active @endif" href="{{ route('dash.template') }}">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                  Templates
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link @if(request()->is('admin/dashboard/pages')) active @endif" href="{{ route('dash.pages') }}">
                  Pages
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link @if(request()->is('admin/dashboard/users')) active @endif" href="{{ route('dash.users') }}">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                  Users
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link @if(request()->is('admin/dashboard/configuration')) active @endif" href="{{ route('dash.configuration') }}">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                  Configuration
                </a>
              </li>
            </ul>
          </div>
        </nav>

        <!-- Content -->
        @yield('dash-content')
        <!-- End Content -->
      </div>
    </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="{{ asset('js/bootstrap.js') }}"></script>
  <script src="{{ asset('js/app.js') }}"></script>
  <script type="text/javascript">
    function alert(message, action){
      var value = confirm(message);
      if (value == true) {
        window.location.href = action;
      }
    }
    $(document).ready(function() {
        $('.data-table').DataTable({
          searching: false,
          lengthChange: false,
          orderCellsTop: true,
          fixedHeader: true
        });
    } );
  </script>
  </body>
</html>