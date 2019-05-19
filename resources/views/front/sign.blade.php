@extends('front.index')

@section('content')
<main role="main">
  <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 d-flex align-items-center order-md-2">
              <div class="w-100 py-5 px-md-5 px-xl-6 position-relative">
                <div class="mb-3">
                  <h2>Welcome back</h2>
                </div>
                <form class="form-validate" action="{{ route('login') }}" method="post">
                  @csrf
                  <div class="form-group">
                    <label for="email" class="form-label"> Email Address</label>
                    <input name="email" id="email" type="email" placeholder="name@address.com" autocomplete="off" required="" data-msg="Please enter your email" class="form-control">
                  </div>
                  <div class="form-group mb-4">
                    <div class="row">
                      <div class="col">
                        <label for="loginPassword" class="form-label"> Password</label>
                      </div>
                      <div class="col-auto"><a href="#" class="form-text small">Forgot password?</a></div>
                    </div>
                    <input name="password" id="password" placeholder="Password" type="password" required="" data-msg="Please enter your password" class="form-control">
                  </div>
                  <div class="form-group mb-4">
                    <div class="custom-control custom-checkbox">
                      <input id="loginRemember" type="checkbox" class="custom-control-input">
                      <label for="loginRemember" class="custom-control-label text-muted"> <span class="text-sm">Remember me</span></label>
                    </div>
                  </div>
                  <!-- Submit-->
                  <button class="btn btn-lg btn-block btn-primary">Sign in</button>
                  <hr class="my-4">
                  <p class="text-center"><small class="text-muted text-center">Don't have an account yet? <a href="{{ route('register') }}">Sign Up                </a></small></p>
                </form>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 d-flex order-md-1">
              <div class="w-100 py-5 px-md-5 px-xl-6 position-relative">
                <div class="mb-3">
                  <img src="{{ asset('svg/500.svg') }}" class="img-fluid">
                </div>
              </div>
            </div>
        </div>
    </div>
</main>
@endsection