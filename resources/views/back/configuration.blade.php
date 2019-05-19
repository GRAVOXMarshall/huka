@extends('back.index')

@section('dash-content')
	<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Configuration</h1>
        @if(Auth::guard('admins')->user())
          {{ Auth::guard('admins')->user()->email }}
        @endif
      </div>
      <h1>Hola compa</h1>
    </main>
@endsection