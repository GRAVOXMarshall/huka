@extends('back.index')

@section('dash-content')
	<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
		<div class="row d-flex align-items-center">
	        <div class="col-md-12 pt-3 pb-2 mb-3">
	            <h2>Select the type of editor</h2>
	            <p>These buttons load the pages according to the selected option.</p>
	        </div>
	    </div>
	    @if (session('status'))
		    <div class="alert alert-success">
		        {{ session('status') }}
		    </div>
		@endif
		<div class="row mb-3">
		  <div class="col-6">
		    <a class="btn btn-outline-primary btn-block" href="{{ route('select.type.editor', ['type' => 'F']) }}" role="button" target="_blank">
		    	<h3>Front-End</h3>
			</a>
		  </div>
		  <div class="col-6">
		    <a class="btn btn-outline-primary btn-block" href="{{ route('select.type.editor', ['type' => 'B']) }}" role="button" target="_blank">
		    	<h3>Back-End</h3>
			</a>
		  </div>
		</div>
    </main>
@endsection