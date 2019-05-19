@extends('front.index')
@section('scripts')
@section('content')
<main role="main">
  <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 order-md-2">
                <img src="{{ asset('cx.png') }}" class="img-fluid" alt="Responsive image">
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 align-self-center order-md-1">
                <h2 class="featurette-heading">Oh yeah, it’s that good. <span class="text-muted">See for yourself.</span></h2>
                <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
            </div>
        </div>
    </div>
</main>
@endsection