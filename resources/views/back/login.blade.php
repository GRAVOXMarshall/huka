<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">


    <style>
        html,
        body {
          height: 100%;
        }

        body {
          display: -ms-flexbox;
          display: flex;
          -ms-flex-align: center;
          align-items: center;
          padding-top: 40px;
          padding-bottom: 40px;
          background-color: #f5f5f5;
        }

        .form-signin {
          width: 100%;
          max-width: 425px;
          padding: 15px;
          margin: auto;
        }
        .form-signin .checkbox {
          font-weight: 400;
        }
        .form-signin .form-control {
          position: relative;
          box-sizing: border-box;
          height: auto;
          padding: 10px;
          font-size: 16px;
        }
        .form-signin .form-control:focus {
          z-index: 2;
        }
        .form-signin input[type="email"] {
          margin-bottom: -1px;
          border-bottom-right-radius: 0;
          border-bottom-left-radius: 0;
        }
        .form-signin input[type="password"] {
          margin-bottom: 10px;
          border-top-left-radius: 0;
          border-top-right-radius: 0;
        }
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
    <link href="signin.css" rel="stylesheet">
  </head>
    <body>
        <form class="form-signin" action="{{ route('admin.login') }}" method="post">
          @csrf
          <div class="text-center mb-0">
              <img  src="{{ asset('svg/brand/creativingx.svg') }}" alt="" width="240" height="100">
          </div>
          <div class="text-center mb-4">Beta 1.0</div>
            <div class="card" style="width: 25rem;">
                <div class="card-body">
                    <label for="inputEmail" class="text-left">Email address</label>
                    <input type="email" name="email" id="inputEmail" class="form-control mb-4" placeholder="Email address" required autofocus>
                    <label for="inputPassword">Password</label>
                    <input type="password" name="password" id="inputPassword" class="form-control mb-4" placeholder="Password" required="">
                    <div class="checkbox mb-3">
                    <label>
                      <input type="checkbox" value="remember-me"> Remember me
                    </label>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block">Sign in</button>
                </div>
            </div>
            <p class="mt-5 mb-3 text-muted text-center">© Creativing X 2019 - All rights reserved</p>
        </form>
    </body>
</html>
