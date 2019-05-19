<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/editor.css') }}">
    <!-- Custom styles for this template -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
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
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/editor.js') }}"></script>
    <script src="{{ asset('js/grapesjs-plugin.js') }}"></script>
  </head>
  <body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Company name</a>
      <ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
        <li class="nav-item">
          <a class="nav-link p-2" href="/admin/editor" target="_blank" rel="noopener" aria-label="GitHub">Edit Web</a>
        </li>
        <li class="nav-item">
          <a class="nav-link p-2" href="#" target="_blank" rel="noopener" aria-label="GitHub">View Web</a>
        </li>
      </ul>
    </nav>
    <br><br><br><br>
    <div class="container-fluid card">
      <div class="row card-header">
        <div class="col-12">
          <ul class="nav nav-tabs card-header-tabs" id="step-module" role="tablist">
            @foreach($configurations as $configuration)
              <li class="nav-item">
                <a id="step-{{ $configuration->step }}" class="nav-link {{ $configuration->step == 1 ? 'active' : '' }} {{ ($configuration->step != 1 && is_null($configuration->value)) ? 'disabled' : '' }}" form-submit="config-form-{{ $configuration->step }}" data-toggle="tab" href="#configuration-{{ $configuration->step }}" role="tab" aria-controls="{{ $configuration->name }}" aria-selected="true">{{ $configuration->name }}</a>
              </li>
            @endforeach
          </ul>
        </div>
      </div>
      <div class="row card-body">
        <div class="col-12 tab-content" id="step-content" style="height: 380px;">
          @yield('content')
        </div>
      </div>
      <div class="card-footer row justify-content-between">
        <div class="col-6 text-left">
          <button type="button" class="btn btn-primary">Previous</button>
        </div>
        <div class="col-6 text-right">
          <button type="button" class="btn btn-primary btn-next">Next</button>
        </div>
      </div>
    </div>
  </body>
</html>