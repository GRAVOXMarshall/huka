@extends('back.admins')

@section('user-content')
<br><br>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12" align="center">
			 <h1 class="h3 text-primary font-weight-normal mb-0"><strong>Registry Admin</strong></span></h1>
		</div>
	</div><br><br>

	<div class="col-md-12">
           @if(session()->has('txt'))
         <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('txt') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
          </div>
          <div class="col-md-12">
        @endif 
        @if(session()->has('error'))
         <div class="alert alert-danger alert-dismissible fade show" role="alert">
              {{ session('error') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
        @endif
      </div>
	<form action="{{ route('dash.users.post') }}" id="form" method="post" class="js-validate">
		@csrf
		<div class="row">
			<div class="col-md-6 col-6">
				<p><strong>Firstname</strong><span class="text-danger">*</span></p> 
				<input type="text" class="form-control" name="firstname" value="{{ old('firstname') }}" required>
			</div>
			<div class="col-md-6 col-6">
				<p><strong>Lastname</strong><span class="text-danger">*</span></p> 
				<input type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" required>
			</div>
		</div><br>
		<div class="row">
			<div class="col-md-6 col-6">
				<p><strong>Email</strong><span class="text-danger">*</span></p> 
				<input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
			</div>
			<div class="col-md-6 col-6">
				<p><strong>Password</strong><span class="text-danger">*</span></p> 
				<input type="password" class="form-control" name="pass"    required>
				<p   style="color: gray;"><strong>*Greater than or equal to 6 characters*</strong></p>
			</div>
		</div><br>
		<div class="row">
			<div class="col-md-12 col-12">
				<p><strong>Group</strong><span class="text-danger">*</span></p> 
				<select class="form-control" name="group" required>
					<option value="0" selected>[Select Groups..]</option>
					@if(isset($group) && $group !== [])
						
						@foreach($group as $groups)	
						<option value="{{ $groups['id'] }}">{{$groups['name'] }}</option>
						@endforeach
					@endif
				</select>
			</div>
		</div><br>
		<div class="row">
			<div class="col-md-12 col-12" align="center">
				<button class="btn btn-primary cgt" style="width: 120px;">Submit</button>
			</div>
		</div>
	</form>

</div>
@endsection