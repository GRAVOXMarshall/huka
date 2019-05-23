@extends('back.admins')

@section('user-content')
<br><br>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12" align="center">
			<h1 class="h3 text-primary font-weight-normal mb-0"><strong>Configuration {{ $group->name }}</strong></h1>
		</div>
	</div><br>
	<div class="texto"  >
		
	</div>
	<div class="row">
		<div class="col-md-6" style="border-right: black 1px solid;">
			<h5 align="center"><strong>Permisos</strong></h5>
			<dt>
				 
			@foreach($permits as $permit)
			<dd>
				<!--<div class="custom-control custom-checkbox">
				  <input type="checkbox" route="{{ route('test.data') }}" data="{{ $permit->id }}-{{ $group->id }}" class="custom-control-input btna" id="defaultChecked{{ $permit->id }}" >
				  <label class="custom-control-label" for="defaultChecked{{ $permit->id }}">{{$permit->name}}</label>
				</div>-->
				@if($permitGroup->contains('permit_id', $permit->id))
					<div class="custom-control custom-checkbox">
					  <input type="checkbox" route="{{ route('test.data') }}" data="{{ $permit->id }}-{{ $group->id }}" class="custom-control-input btnPermit" id="defaultChecked{{ $permit->id }}" checked>
					  <label class="custom-control-label" for="defaultChecked{{ $permit->id }}">{{$permit->name}}</label>
					</div>
				@else
					<div class="custom-control custom-checkbox">
					  <input type="checkbox" route="{{ route('test.data') }}" data="{{ $permit->id }}-{{ $group->id }}" class="custom-control-input btnPermit" id="defaultChecked{{ $permit->id }}" >
					  <label class="custom-control-label" for="defaultChecked{{ $permit->id }}">{{$permit->name}}</label>
					</div>
				@endif
				<!-- @foreach($permitGroup as $perGroup)
				 	@if($permit->id === $perGroup->permit_id  )
				 		<div class="custom-control custom-checkbox">
						  <input type="checkbox" route="{{ route('test.data') }}" data="{{ $permit->id }}-{{ $group->id }}" class="custom-control-input btna" id="defaultChecked{{ $permit->id }}" checked>
						  <label class="custom-control-label" for="defaultChecked{{ $permit->id }}">{{$permit->name}}</label>
						</div>
				 	@endif

				 	@if(!$permit->id === $perGroup->permit_id )
				 		<div class="custom-control custom-checkbox">
						  <input type="checkbox" route="{{ route('test.data') }}" data="{{ $permit->id }}-{{ $group->id }}" class="custom-control-input btna" id="defaultChecked{{ $permit->id }}" >
						  <label class="custom-control-label" for="defaultChecked{{ $permit->id }}">{{$permit->name}}</label>
						</div>
				 	@endif
				 @endforeach-->
				 
			</dd> 
			@endforeach
			</dt>
		</div>
		<div class="col-md-6">
			<h5 align="center"><strong>Usuarios</strong></h5>
			<dt>
			@foreach($admins as $admin) 
				@if($admin->group_id != null)
					<dd>
						<div class="custom-control custom-checkbox">
						  <input type="checkbox"  route="{{ route('test.data') }}" data="{{ $admin->id }}-{{ $group->id }}" class="custom-control-input btnGroup" id="defaultCheckedAdmin{{ $admin->id }}" checked>
						  <label class="custom-control-label" for="defaultCheckedAdmin{{ $admin->id }}">{{$admin->email}}</label>
						</div>
					</dd>
				@else
					<dd>
						<div class="custom-control custom-checkbox">
						  <input type="checkbox"  route="{{ route('test.data') }}" data="{{ $admin->id }}-{{ $group->id }}" class="custom-control-input btnGroup" id="defaultCheckedAdmin{{ $admin->id }}">
						  <label class="custom-control-label" for="defaultCheckedAdmin{{ $admin->id }}">{{$admin->email}}</label>
						</div>
					</dd>
				@endif
			@endforeach
			</dt>
		</div>
	</div>
</div>
@endsection